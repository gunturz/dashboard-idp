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
        $notifications = $this->getNotifications();

        // Asumsi mentor memiliki talents bimbingan via relasi getMenteesAttribute yang ada di model User
        $talents = $user->mentees->filter(function ($mentee) {
            $latestPlan = $mentee->all_promotion_plans->first();
            if ($latestPlan && !$latestPlan->is_active && in_array($latestPlan->status_promotion, ['Approved Panelis', 'Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'])) {
                return false;
            }
            return true;
        })->values();

        // Collect stats per talent
        $menteesList = $talents->map(function ($talent) use ($user) {
            $gaps = collect();
            $details = optional($talent->assessmentSession)->details;
            if ($details) {
                // Ambil gap yang telah dipilih oleh PDC Admin (priority_1, priority_2, dll)
                $chosenGaps = $details->filter(
                    function ($d) {
                        return is_string($d->notes) && str_starts_with($d->notes, 'priority_');
                    }
                )->sortBy(
                        function ($d) {
                            preg_match('/priority_(\d+)/', $d->notes, $matches);
                            return isset($matches[1]) ? (int) $matches[1] : 999;
                        }
                    )->values();

                if ($chosenGaps->isNotEmpty()) {
                    $gaps = $chosenGaps;
                } else {
                    // Default fallback: 3 gap terendah (paling negatif)
                    $gaps = $details->sortBy('gap_score')->take(3)->values();
                }
            }

            // Hitung status IDP logbook HANYA UNTUK mentor ini, tetapi ikut sertakan Learning
            $idpActivities = IdpActivity::with('type')
                ->where('user_id_talent', $talent->id)
                ->where('is_active', true)
                ->where(
                    function ($q) use ($user) {
                        $q->where('verify_by', $user->id)
                            ->orWhereHas(
                                'type',
                                function ($qType) {
                                    $qType->where('type_name', 'Learning');
                                }
                            );
                    }
                )
                ->get();
            $pendingActivities = $idpActivities->filter(
                function ($activity) {
                    return $activity->status === 'Pending' || $activity->status === null || $activity->status === '';
                }
            );
            $pending = $pendingActivities->count();
            $approved = $idpActivities->whereIn('status', ['Approve', 'Approved'])->count();
            $rejected = $idpActivities->whereIn('status', ['Reject', 'Rejected'])->count();
            $hasHistory = ($approved + $rejected) > 0;

            // Determine which tab needs validation
            $pendingTab = '';
            if ($pending > 0) {
                if ($pendingActivities->contains(fn($act) => $act->type && $act->type->type_name === 'Exposure')) {
                    $pendingTab = '#exposure';
                } elseif ($pendingActivities->contains(fn($act) => $act->type && $act->type->type_name === 'Mentoring')) {
                    $pendingTab = '#mentoring';
                } elseif ($pendingActivities->contains(fn($act) => $act->type && $act->type->type_name === 'Learning')) {
                    $pendingTab = '#learning';
                }
            }

            // Hitung persentase untuk Exposure, Mentoring, Learning (asumsi target 6 untuk mockup)
            $countExposure = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Exposure')->count();
            $countMentoring = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Mentoring')->count();
            $countLearning = $idpActivities->filter(fn($act) => $act->type && $act->type->type_name === 'Learning')->count();

            // Atur default target = 6 (hanya contoh untuk pie chart)
            $target = 6;

            $latestSubmissionAt = $idpActivities->max('created_at');

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
                'pending_tab' => $pendingTab,
                'has_pending' => $pending > 0,
                'has_history' => $hasHistory,
                'progress' => [
                    'exposure' => ['count' => $countExposure, 'target' => $target, 'pct' => min(100, round(($countExposure / $target) * 100))],
                    'mentoring' => ['count' => $countMentoring, 'target' => $target, 'pct' => min(100, round(($countMentoring / $target) * 100))],
                    'learning' => ['count' => $countLearning, 'target' => $target, 'pct' => min(100, round(($countLearning / $target) * 100))],
                ],
                'latest_submission_at' => $latestSubmissionAt?->timestamp ?? 0,
            ];
        });

        $menteesList = $menteesList
            ->sortByDesc('latest_submission_at')
            ->values();

        return view('mentor.dashboard', compact('user', 'menteesList', 'notifications'));
    }

    public function logbook(Request $request)
    {
        $user = Auth::user();
        $notifications = $this->getNotifications();
        // Tampilkan semua mentee yang memiliki aktivitas terkait mentor (tidak hanya yang pending)
        // agar setelah validasi talent tetap muncul di dropdown
        $mentees = $user->mentees->filter(function ($mentee) use ($user) {
            return IdpActivity::where('user_id_talent', $mentee->id)
                ->where('is_active', true)
                ->where(
                    function ($q) use ($user) {
                        $q->where('verify_by', $user->id)
                            ->orWhereHas(
                                'type',
                                function ($qType) {
                                    $qType->where('type_name', 'Learning');
                                }
                            );
                    }
                )
                ->exists();
        })->values();

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
                // Ambil SEMUA aktivitas (pending, approved, rejected) agar status perubahan
                // langsung terlihat setelah aksi validasi tanpa berpindah halaman
                $activities = IdpActivity::with(['type', 'verifier'])
                    ->where('user_id_talent', $selectedTalent->id)
                    ->where('is_active', true)
                    ->where(function ($q) use ($user) {
                        $q->where('verify_by', $user->id)
                            ->orWhereHas(
                                'type',
                                function ($qType) {
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

        return view('mentor.validasi', compact(
            'user',
            'mentees',
            'selectedTalent',
            'exposureData',
            'mentoringData',
            'learningData',
            'notifications'
        ));
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user();
        $notifications = $this->getNotifications();
        $finalStatuses = ['Approved Panelis', 'Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'];

        $talents = User::with([
            'company',
            'department',
            'position',
            'all_promotion_plans' => function ($q) use ($finalStatuses) {
                $q->where('is_active', false)
                    ->whereIn('status_promotion', $finalStatuses)
                    ->orderByDesc('created_at');
            },
            'all_promotion_plans.targetPosition',
            'all_promotion_plans.developmentSession.sourcePosition',
        ])
            ->whereHas('all_promotion_plans', function ($q) use ($user, $finalStatuses) {
                $q->where('is_active', false)
                    ->whereIn('status_promotion', $finalStatuses)
                    ->where(function ($mentorQuery) use ($user) {
                        $mentorQuery->whereJsonContains('mentor_ids', (string) $user->id)
                            ->orWhereJsonContains('mentor_ids', $user->id);
                    });
            })
            ->orWhere(function ($q) use ($user, $finalStatuses) {
                $q->where('mentor_id', $user->id)
                    ->whereHas('all_promotion_plans', function ($planQuery) use ($finalStatuses) {
                        $planQuery->where('is_active', false)
                            ->whereIn('status_promotion', $finalStatuses)
                            ->where(function ($legacyMentorQuery) {
                                $legacyMentorQuery->whereNull('mentor_ids')
                                    ->orWhereJsonLength('mentor_ids', 0);
                            });
                    });
            })
            ->get();

        // One table row represents one completed development session.
        $completedTalents = collect();
        foreach ($talents as $talent) {
            foreach ($talent->all_promotion_plans as $plan) {
                $mentorIds = collect($plan->mentor_ids ?? [])->map(fn($id) => (string) $id);
                $isMentorPlan = $mentorIds->contains((string) $user->id)
                    || ($mentorIds->isEmpty() && (int) $talent->mentor_id === (int) $user->id);

                if (!$isMentorPlan) {
                    continue;
                }

                $historyRow = $talent->replicate();
                $historyRow->id = $talent->id;
                $historyRow->exists = true;
                $historyRow->setRelations($talent->getRelations());
                $historyRow->promotion_plan = $plan;
                $historyRow->archive_session_id = $plan->development_session_id;

                if ($plan->developmentSession?->sourcePosition) {
                    $historyRow->setRelation('position', $plan->developmentSession->sourcePosition);
                }

                $completedTalents->push($historyRow);
            }
        }

        $completedTalents = $completedTalents
            ->sortByDesc(function ($talent) {
                return optional(optional($talent->promotion_plan)->developmentSession)->completed_at
                    ?? optional($talent->promotion_plan)->updated_at
                    ?? optional($talent->promotion_plan)->created_at;
            })
            ->values();

        return view('mentor.riwayat', compact('user', 'completedTalents', 'notifications'));
    }

    public function riwayatLogbook(Request $request, $talentId)
    {
        $user = Auth::user();
        $notifications = $this->getNotifications();
        $sessionId = $request->query('session_id');
        $talent = \App\Models\User::with([
            'position',
            'department',
            'company',
            'all_promotion_plans.targetPosition',
            'all_promotion_plans.developmentSession.sourcePosition',
        ])->findOrFail($talentId);

        $archivedPlan = $sessionId
            ? $talent->all_promotion_plans->firstWhere('development_session_id', (int) $sessionId)
            : $talent->all_promotion_plans->first(fn($plan) => !$plan->is_active);

        $talent->promotion_plan = $archivedPlan;
        if ($archivedPlan?->developmentSession?->sourcePosition) {
            $talent->setRelation('position', $archivedPlan->developmentSession->sourcePosition);
        }


        // Ambil aktivitas logbook talent untuk sesi riwayat yang dipilih.
        $activities = \App\Models\IdpActivity::with(['type', 'verifier'])
            ->where('user_id_talent', $talentId)
            ->when($sessionId, fn($q) => $q->where('development_session_id', $sessionId))
            ->orderBy('created_at', 'desc')
            ->get();

        $exposureData = [];
        $mentoringData = [];
        $learningData = [];

        foreach ($activities as $act) {
            $typeName = $act->type ? $act->type->type_name : '';

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

            $base = [
                'id' => $act->id,
                'mentor' => $act->verifier ? $act->verifier->nama : '-',
                'tema' => $act->theme,
                'tanggal_update' => $act->updated_at,
                'tanggal' => $act->activity_date,
                'status' => $act->status,
                'file_paths' => $docPaths,
                'file_names' => $docNames,
            ];

            if ($typeName === 'Exposure') {
                $exposureData[] = array_merge($base, [
                    'lokasi' => $act->location,
                    'aktivitas' => $act->activity,
                    'deskripsi' => $act->description,
                ]);
            } elseif ($typeName === 'Mentoring') {
                $mentoringData[] = array_merge($base, [
                    'lokasi' => $act->location,
                    'deskripsi' => $act->description,
                    'action_plan' => $act->action_plan,
                ]);
            } elseif ($typeName === 'Learning') {
                $learningData[] = array_merge($base, [
                    'sumber' => $act->activity,
                    'platform' => $act->platform,
                ]);
            }
        }

        return view('mentor.riwayat-logbook', compact(
            'user',
            'talent',
            'exposureData',
            'mentoringData',
            'learningData',
            'notifications'
        ));
    }

    public function updateLogbookStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $activity = IdpActivity::with('developmentSession')->findOrFail($id);

        if (!$activity->is_active || ($activity->developmentSession && !$activity->developmentSession->is_active)) {
            return back()->with('error', 'Sesi talent ini sudah selesai, sehingga logbook tidak dapat divalidasi lagi.');
        }

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

        $typeName = $activity->type?->type_name ?? 'IDP Monitoring';
        $mentorName = $mentor->nama ?? 'Mentor';

        $this->addNotificationToUser(
            $activity->user_id_talent,
            $typeName . ' ' . $request->status,
            '<span class="font-semibold">' . e($mentorName) . '</span> telah memvalidasi IDP Monitoring <span class="font-semibold">' . e($typeName) . '</span> Anda dengan status <span class="font-semibold">' . $request->status . '</span>.',
            $request->status == 'Approved' ? 'success' : 'warning'
        );

        $this->notifyPdcAdmins(
            'Validasi Mentor Selesai',
            'Mentor <span class="font-semibold">' . e($mentorName) . '</span> telah memberikan validasi <span class="font-semibold">' . e($request->status) . '</span> untuk IDP Monitoring <span class="font-semibold">' . e($typeName) . '</span> milik talent <span class="font-semibold">' . e(optional($activity->talent)->nama ?? 'Talent') . '</span>.',
            $request->status === 'Approved' ? 'success' : 'warning'
        );

        return redirect()
            ->route('mentor.validasi', ['talent_id' => $activity->user_id_talent])
            ->with('success', 'Status aktivitas berhasil diperbarui menjadi ' . $request->status . '.');
    }

    public function logbookItemDetail($id)
    {
        $user = Auth::user();
        $notifications = $this->getNotifications();
        $activity = IdpActivity::with(['talent', 'verifier', 'type'])->findOrFail($id);
        return view('mentor.riwayat-detail', compact('user', 'activity', 'notifications'));
    }
}
