<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\IdpActivity;

class MentorDashboardController extends Controller
{
    public function notifikasi()
    {
        return view('mentor.notifikasi', [
            'user' => Auth::user(),
            'notifications' => $this->getNotifications()
        ]);
    }



    public function dashboard()
    {
        $user = Auth::user();

        // Asumsi mentor memiliki talents bimbingan via relasi getMenteesAttribute yang ada di model User
        $talents = $user->mentees;

        // Collect stats per talent
        $menteesList = $talents->map(function ($talent) use ($user) {
            $gaps = collect();
            $details = optional($talent->assessmentSession)->details;
            if ($details) {
                // Ambil gap yang telah dipilih oleh PDC Admin (priority_1, priority_2, dll)
                $chosenGaps = $details->filter(function ($d) {
                            return is_string($d->notes) && str_starts_with($d->notes, 'priority_');
                        }
                        )->sortBy(function ($d) {
                            preg_match('/priority_(\d+)/', $d->notes, $matches);
                            return isset($matches[1]) ? (int)$matches[1] : 999;
                        }
                        )->values();

                        if ($chosenGaps->isNotEmpty()) {
                            $gaps = $chosenGaps;
                        }
                        else {
                            // Default fallback: 3 gap terendah (paling negatif)
                            $gaps = $details->sortBy('gap_score')->take(3)->values();
                        }
                    }

                    // Hitung status IDP logbook HANYA UNTUK mentor ini, tetapi ikut sertakan Learning
                    $idpActivities = IdpActivity::with('type')
                        ->where('user_id_talent', $talent->id)
                        ->where(function ($q) use ($user) {
                    $q->where('verify_by', $user->id)
                        ->orWhereHas('type', function ($qType) {
                        $qType->where('type_name', 'Learning');
                    }
                    );
                }
            )
                ->get();
            $pending = $idpActivities->where('status', 'Pending')->count();
            $approved = $idpActivities->whereIn('status', ['Approve', 'Approved'])->count();
            $rejected = $idpActivities->whereIn('status', ['Reject', 'Rejected'])->count();

            // Hitung persentase untuk Exposure, Mentoring, Learning (asumsi target 6 untuk mockup)
            $countExposure = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Exposure')->count();
            $countMentoring = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Mentoring')->count();
            $countLearning = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Learning')->count();

            // Atur default target = 6 (hanya contoh untuk pie chart)
            $target = 6;

            return [
            'id' => $talent->id,
            'name' => $talent->nama,
            'foto' => $talent->foto,
            'position' => optional($talent->position)->position_name ?? '-',
            'department' => optional($talent->department)->nama_department ?? '-',
            'gaps' => $gaps,
            'status' => [
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            ],
            'progress' => [
            'exposure' => ['count' => $countExposure, 'target' => $target, 'pct' => min(100, round(($countExposure / $target) * 100))],
            'mentoring' => ['count' => $countMentoring, 'target' => $target, 'pct' => min(100, round(($countMentoring / $target) * 100))],
            'learning' => ['count' => $countLearning, 'target' => $target, 'pct' => min(100, round(($countLearning / $target) * 100))],
            ]
            ];
        });

        return view('mentor.dashboard', compact('user', 'menteesList'));
    }

    public function logbook(Request $request)
    {
        $user = Auth::user();
        $mentees = $user->mentees;

        $talentId = $request->get('talent_id');
        $selectedTalent = null;

        $exposureData = [];
        $mentoringData = [];
        $learningData = [];

        if ($mentees->isNotEmpty()) {
            if ($talentId) {
                // Cari talent berdasarkan id
                $selectedTalent = $mentees->firstWhere('id', $talentId);
            }
            if (!$selectedTalent) {
                // Default ke mentee pertama
                $selectedTalent = $mentees->first();
            }

            if ($selectedTalent) {
                // Ambil aktivitas dari talent yang dipilih: 
                // Exposure & Mentoring yang divalidasi oleh mentor ini, ditambah semua aktivitas Learning
                $activities = IdpActivity::with(['type', 'verifier'])
                    ->where('user_id_talent', $selectedTalent->id)
                    ->where(function ($q) use ($user) {
                    $q->where('verify_by', $user->id)
                        ->orWhereHas('type', function ($qType) {
                        $qType->where('type_name', 'Learning');
                    }
                    );
                })
                    ->orderBy('created_at', 'desc')
                    ->get();

                foreach ($activities as $act) {
                    $typeName = $act->type ? $act->type->type_name : '';

                    // Decode list file path
                    $docPaths = [];
                    $docNames = [];
                    if ($act->document_path) {
                        if (str_starts_with($act->document_path, '["')) {
                            $docPaths = json_decode($act->document_path, true) ?? [];
                            $docNames = $act->file_name ? explode(', ', $act->file_name) : [];
                        }
                        else {
                            $docPaths = [$act->document_path];
                            $docNames = [$act->file_name ?? ''];
                        }
                    }

                    if ($typeName === 'Exposure') {
                        $exposureData[] = [
                            'id' => $act->id,
                            'mentor' => $act->verifier ? $act->verifier->nama : '-',
                            'tema' => $act->theme,
                            'tanggal_update' => $act->updated_at,
                            'tanggal' => $act->activity_date,
                            'lokasi' => $act->location,
                            'aktivitas' => $act->activity,
                            'deskripsi' => $act->description,
                            'file_paths' => $docPaths,
                            'file_names' => $docNames,
                            'status' => $act->status,
                        ];
                    }
                    elseif ($typeName === 'Mentoring') {
                        $mentoringData[] = [
                            'id' => $act->id,
                            'mentor' => $act->verifier ? $act->verifier->nama : '-',
                            'tema' => $act->theme,
                            'tanggal_update' => $act->updated_at,
                            'tanggal' => $act->activity_date,
                            'lokasi' => $act->location,
                            'deskripsi' => $act->description,
                            'action_plan' => $act->action_plan,
                            'file_paths' => $docPaths,
                            'file_names' => $docNames,
                            'status' => $act->status,
                        ];
                    }
                    elseif ($typeName === 'Learning') {
                        $learningData[] = [
                            'id' => $act->id,
                            'sumber' => $act->activity,
                            'tema' => $act->theme,
                            'tanggal_update' => $act->updated_at,
                            'tanggal' => $act->activity_date,
                            'platform' => $act->platform,
                            'file_paths' => $docPaths,
                            'file_names' => $docNames,
                            'status' => $act->status,
                        ];
                    }
                }
            }
        }

        return view('mentor.logbook', compact(
            'user', 'mentees', 'selectedTalent', 'exposureData', 'mentoringData', 'learningData'
        ));
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user();
        $mentees = $user->mentees;

        $talentId = $request->get('talent_id');
        $selectedTalent = null;

        $exposureData = [];
        $mentoringData = [];
        $learningData = [];

        if ($mentees->isNotEmpty()) {
            if ($talentId) {
                // Cari talent berdasarkan id
                $selectedTalent = $mentees->firstWhere('id', $talentId);
            }
            if (!$selectedTalent) {
                // Default ke mentee pertama
                $selectedTalent = $mentees->first();
            }

            if ($selectedTalent) {
                $activities = IdpActivity::with(['type', 'verifier'])
                    ->where('user_id_talent', $selectedTalent->id)
                    ->where(function ($q) use ($user) {
                        $q->where('verify_by', $user->id)
                            ->orWhereHas('type', function ($qType) {
                                $qType->where('type_name', 'Learning');
                            });
                    })
                    ->whereIn('status', ['Approve', 'Approved'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                foreach ($activities as $act) {
                    $typeName = $act->type ? $act->type->type_name : '';

                    // Decode list file path
                    $docPaths = [];
                    $docNames = [];
                    if ($act->document_path) {
                        if (str_starts_with($act->document_path, '["')) {
                            $docPaths = json_decode($act->document_path, true) ?? [];
                            $docNames = $act->file_name ? explode(', ', $act->file_name) : [];
                        } else {
                            $docPaths = [$act->document_path];
                            $docNames = [$act->file_name ?? ''];
                        }
                    }

                    if ($typeName === 'Exposure') {
                        $exposureData[] = [
                            'id' => $act->id,
                            'mentor' => $act->verifier ? $act->verifier->nama : '-',
                            'tema' => $act->theme,
                            'tanggal_update' => $act->updated_at,
                            'tanggal' => $act->activity_date,
                            'lokasi' => $act->location,
                            'aktivitas' => $act->activity,
                            'deskripsi' => $act->description,
                            'file_paths' => $docPaths,
                            'file_names' => $docNames,
                            'status' => $act->status,
                        ];
                    } elseif ($typeName === 'Mentoring') {
                        $mentoringData[] = [
                            'id' => $act->id,
                            'mentor' => $act->verifier ? $act->verifier->nama : '-',
                            'tema' => $act->theme,
                            'tanggal_update' => $act->updated_at,
                            'tanggal' => $act->activity_date,
                            'lokasi' => $act->location,
                            'deskripsi' => $act->description,
                            'action_plan' => $act->action_plan,
                            'file_paths' => $docPaths,
                            'file_names' => $docNames,
                            'status' => $act->status,
                        ];
                    } elseif ($typeName === 'Learning') {
                        $learningData[] = [
                            'id' => $act->id,
                            'sumber' => $act->activity,
                            'tema' => $act->theme,
                            'tanggal_update' => $act->updated_at,
                            'tanggal' => $act->activity_date,
                            'platform' => $act->platform,
                            'file_paths' => $docPaths,
                            'file_names' => $docNames,
                            'status' => $act->status,
                        ];
                    }
                }
            }
        }

        return view('mentor.riwayat', compact(
            'user', 'mentees', 'selectedTalent', 'exposureData', 'mentoringData', 'learningData'
        ));
    }

    public function updateLogbookStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $activity = IdpActivity::findOrFail($id);

        // Ensure the mentor is matching
        $mentor = Auth::user();
        if ($activity->verify_by !== $mentor->id) {
            // Check if they are actually mentoring this talent via relationships just in case (fallback)
            $isMentee = $mentor->mentees->contains('id', $activity->user_id_talent);
            if (!$isMentee) {
                return back()->with('error', 'Anda tidak memiliki hak akses untuk memvalidasi logbook ini.');
            }
        }

        $activity->update([
            'status' => $request->status,
        ]);

        $this->addNotificationToUser(
            $activity->user_id_talent,
            'Logbook ' . $request->status,
            'Aktivitas logbook Anda telah diperbarui menjadi <span class="font-semibold">' . $request->status . '</span> oleh mentor Anda.',
            $request->status == 'Approved' ? 'success' : 'warning'
        );

        return back()->with('success', 'Status aktivitas berhasil diperbarui menjadi ' . $request->status . '.');
    }

    public function logbookItemDetail($id)
    {
        $user = Auth::user();
        $activity = IdpActivity::with(['talent', 'verifier', 'type'])->findOrFail($id);
        return view('mentor.logbook-item', compact('user', 'activity'));
    }
}
