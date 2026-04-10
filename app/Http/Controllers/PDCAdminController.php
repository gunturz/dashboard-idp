<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;
use App\Models\PromotionPlan;
use App\Models\ImprovementProject;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PDCAdminController extends Controller
{
    public function notifikasi()
    {
        return view('pdc_admin.notifikasi', [
            'user' => auth()->user(),
            'notifications' => $this->getNotifications()
        ]);
    }



    public function dashboard()
    {
        $user = auth()->user();

        // Summary Cards
        $totalUsers = User::whereDoesntHave('role', fn($q) => $q->where('role_name', 'admin'))->count();
        $onProgressTalent = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->join('promotion_plan', 'users.id', '=', 'promotion_plan.user_id_talent')
            ->whereNotNull('promotion_plan.target_position_id')
            ->where('promotion_plan.status_promotion', 'In Progress')
            ->select('users.company_id', 'promotion_plan.target_position_id')
            ->distinct()
            ->get()
            ->count();
        $pendingFinance = ImprovementProject::whereIn('status', ['Pending', 'On Progress'])->count();
        $pendingBOD = PromotionPlan::where('status_promotion', 'Pending BOD')->count();

        // Role statistics
        $roleCounts = [
            'Talent' => User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))->count(),
            'Mentor' => User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->count(),
            'Atasan' => User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->count(),
            'Finance' => User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))->count(),
            'BOD' => User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bo_director', 'bod', 'board_of_directors', 'board_of_director']))->count(),
        ];

        // Fetch the 3 most recent 'In Progress' talents with their relationships
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->whereHas('promotion_plan', function ($q) {
            $q->where('status_promotion', 'In Progress')
                ->whereNotNull('target_position_id');
        })
            ->join('promotion_plan', 'users.id', '=', 'promotion_plan.user_id_talent')
            ->select('users.*')
            ->orderBy('promotion_plan.created_at', 'desc')
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->take(3)
            ->get();

        // Grouping: Company ID -> Target Position ID -> Talents
        $groupedData = $talents->groupBy('company_id')->map(function ($companyTalents) {
            return [
            'company' => $companyTalents->first()->company,
            'positions' => $companyTalents->groupBy(function ($item) {
                    return $item->promotion_plan->target_position_id ?? 0;
                }
                )->map(function ($positionTalents) {
                    return [
                    'targetPosition' => $positionTalents->first()->promotion_plan->targetPosition ?? null,
                    'talents' => $positionTalents,
                    ];
                }
                ),
                ];
            });

        // Data for Development Plan form (optional, keeping for legacy compatibility)
        $companies = Company::orderBy('nama_company')->get();

        $positions = Position::whereNotIn('position_name', ['Super Admin', 'Board of Directors'])->orderBy('grade_level')->get();
        $mentors = User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

        return view('pdc_admin.dashboard', compact(
            'user', 'groupedData', 'companies', 'positions', 'mentors', 'atasans',
            'totalUsers', 'onProgressTalent', 'pendingFinance', 'pendingBOD', 'roleCounts'
        ));
    }

    public function progressTalent()
    {
        $user = auth()->user();

        // Fetch all talents with their relationships
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->get();

        // Grouping: Company ID -> Target Position ID -> Talents
        $groupedData = $talents->groupBy('company_id')->map(function ($companyTalents) {
            return [
            'company' => $companyTalents->first()->company,
            'positions' => $companyTalents->groupBy(function ($item) {
                    return $item->promotion_plan->target_position_id ?? 0;
                }
                )->map(function ($positionTalents) {
                    return [
                    'targetPosition' => $positionTalents->first()->promotion_plan->targetPosition ?? null,
                    'talents' => $positionTalents,
                    ];
                }
                ),
                ];
            });

        return view('pdc_admin.progress-talent', compact('user', 'groupedData'));
    }

    /**
     * Return talents filtered by company as JSON (for dynamic dropdown via fetch)
     */
    public function getTalentsByCompany(Request $request)
    {
        $companyId = $request->company_id;
        $talents = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->where('company_id', $companyId)
            ->orderBy('nama')
            ->get(['id', 'nama']);
        return response()->json($talents);
    }

    /**
     * Save Development Plan submitted from PDC Admin dashboard
     */
    public function storeDevelopmentPlan(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:company,id',
            'target_position_id' => 'required|exists:position,id',
            'atasan_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'target_date' => 'required|date|after_or_equal:start_date',
            'talents' => 'required|array|min:1',
            'talents.*.talent_id' => 'required|exists:users,id',
            'talents.*.mentors' => 'required|array|min:1',
            'talents.*.mentors.*' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->talents as $talentData) {
                $talentId = $talentData['talent_id'];
                $mentorIds = $talentData['mentors'];
                $primaryMentorId = $mentorIds[0] ?? null;

                // Update mentor & atasan on user (primary mentor only)
                User::where('id', $talentId)->update([
                    'mentor_id' => $primaryMentorId,
                    'atasan_id' => $request->atasan_id,
                ]);

                // Create or update promotion_plan with ALL mentor IDs
                PromotionPlan::updateOrCreate(
                ['user_id_talent' => $talentId],
                [
                    'target_position_id' => $request->target_position_id,
                    'mentor_ids' => $mentorIds, // all selected mentors
                    'status_promotion' => 'In Progress',
                    'start_date' => $request->start_date,
                    'target_date' => $request->target_date,
                ]
                );
            }
        });

        return redirect()->route('pdc_admin.development_plan')
            ->with('success', 'Development Plan berhasil disimpan!');
    }

    public function developmentPlan()
    {
        $user = auth()->user();
        $companies = Company::orderBy('nama_company')->get();
        $departments = Department::orderBy('nama_department')->get();

        $positions = Position::whereNotIn('position_name', ['Super Admin', 'Board of Directors'])->orderBy('grade_level')->get();
        $mentors = User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();


        return view('pdc_admin.development-plan', compact('user', 'companies', 'departments', 'positions', 'mentors', 'atasans'));
    }

    public function detail($company_id, $position_id)
    {
        $user = auth()->user();
        $company = Company::findOrFail($company_id);
        $targetPosition = Position::findOrFail($position_id);

        $talents = User::where('company_id', $company_id)
            ->whereHas('promotion_plan', function ($q) use ($position_id) {
            $q->where('target_position_id', $position_id);
        })
            ->with(['department', 'position', 'mentor', 'atasan', 'assessmentSession.details.competence', 'idpActivities.type', 'improvementProjects.verifier'])
            ->get();

        $competencies = Competence::all();
        $standards = PositionTargetCompetence::where('position_id', $position_id)
            ->pluck('target_level', 'competence_id');

        $financeUsers = User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))
            ->where('company_id', $company_id)
            ->get();

        return view('pdc_admin.detail', compact('user', 'company', 'targetPosition', 'talents', 'competencies', 'standards', 'financeUsers'));
    }

    public function detailTalent($talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'promotion_plan.targetPosition',
            'assessmentSession.details.competence',
            'idpActivities.type',
            'improvementProjects.verifier',
        ])->findOrFail($talent_id);

        // Build a single-item collection so the existing detail.blade.php loop still works
        $talents = collect([$talent]);

        $company = $talent->company;
        $targetPosition = optional($talent->promotion_plan)->targetPosition;

        $competencies = Competence::all();

        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ?PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        $financeUsers = User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))
            ->where('company_id', $talent->company_id)
            ->get();

        return view('pdc_admin.detail', compact('user', 'company', 'targetPosition', 'talents', 'competencies', 'standards', 'financeUsers'));
    }

    public function financeValidation()
    {
        $user = auth()->user();

        $projects = ImprovementProject::with([
            'talent.position',
            'talent.department',
            'talent.promotion_plan.targetPosition',
        ])
            ->orderByRaw("FIELD(status, 'Pending', 'On Progress', 'Verified', 'Rejected')")
            ->get();

        $total = $projects->count();
        $pending = $projects->whereIn('status', ['Pending', 'On Progress'])->count();
        $approved = $projects->where('status', 'Verified')->count();
        $rejected = $projects->where('status', 'Rejected')->count();

        return view('pdc_admin.finance-validation', compact('user', 'projects', 'total', 'pending', 'approved', 'rejected'));
    }

    public function updateFinanceValidation(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Verified,Rejected']);

        $project = ImprovementProject::findOrFail($id);
        $project->update([
            'status' => $request->status,
            'verify_by' => auth()->id(),
            'verify_at' => now(),
        ]);

        $this->addNotificationToUser(
            $project->user_id_talent,
            'Project ' . $request->status,
            'Project Improvement Anda telah diperbarui menjadi <span class="font-semibold">' . $request->status . '</span> oleh Admin.',
            $request->status == 'Verified' ? 'success' : 'warning'
        );

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function kompetensi()
    {
        $user = auth()->user();

        // Core: IDs 1-5, Managerial: IDs 6-10 (based on seeder order)
        $coreCompetencies = Competence::with('questions')->whereBetween('id', [1, 5])->get();
        $managerialCompetencies = Competence::with('questions')->where('id', '>', 5)->get();
        $allCompetencies = Competence::with('questions')->get();

        $positions = Position::whereNotIn('position_name', ['Super Admin', 'Board of Directors'])->orderBy('grade_level')->get();

        // Build a lookup: [position_id][competence_id] => target_level
        $targetScores = PositionTargetCompetence::all()
            ->groupBy('position_id')
            ->map(fn($rows) => $rows->pluck('target_level', 'competence_id'));

        return view('pdc_admin.kompetensi', compact('user', 'coreCompetencies', 'managerialCompetencies', 'allCompetencies', 'positions', 'targetScores'));
    }

    public function updateQuestions(Request $request)
    {
        $competenceId = $request->competence_id;

        foreach ($request->questions as $levelData) {
            $level = $levelData['level'];
            $text = $levelData['text'] ?? '';
            $id = $levelData['id'] ?? null;

            if ($id) {
                \App\Models\Question::where('id', $id)->update(['question_text' => $text]);
            }
            elseif ($text) {
                \App\Models\Question::create([
                    'competence_id' => $competenceId,
                    'level' => $level,
                    'question_text' => $text,
                ]);
            }
        }

        return back()->with('success', 'Questions berhasil diperbarui.');
    }

    public function updateTargetScores(Request $request, $position_id)
    {
        $scores = $request->input('scores'); // array of competence_id => target_level
        if ($scores) {
            foreach ($scores as $comp_id => $level) {
                PositionTargetCompetence::updateOrCreate(
                ['position_id' => $position_id, 'competence_id' => $comp_id],
                ['target_level' => $level]
                );
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Target Score berhasil diperbarui.']);
        }

        // stay on the same tab
        return back()->with('success', 'Target Score berhasil diperbarui.');
    }

    public function user_management()
    {
        $user = auth()->user();
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })->with(['position', 'department', 'company'])->get();

        $mentors = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'mentor');
        })->with(['position', 'department', 'company'])->get();

        $finances = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'finance');
        })->with(['position', 'department', 'company'])->get();

        $bods = User::whereHas('roles', function ($q) {
            $q->whereIn('role_name', ['bo_director', 'bod', 'board_of_directors', 'board_of_director']);
        })->with(['position', 'department', 'company'])->get();

        $atasans = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'atasan');
        })->with(['position', 'department', 'company'])->get();

        $departments = Department::all();
        $positions = Position::all();
        $rolesData = Role::all(); // Provide all roles for the assign modal
        $companies = Company::all();

        return view('pdc_admin.user-management', compact('user', 'talents', 'mentors', 'finances', 'bods', 'atasans', 'departments', 'positions', 'rolesData', 'companies'));
    }

    public function requestFinanceValidation(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'notes' => 'required|string',
            'assigned_finance_id' => 'required|exists:users,id',
        ]);

        $project = ImprovementProject::find($request->project_id);
        if ($project) {
            $project->update([
                'status' => 'Pending',
                'feedback' => $request->notes,
                'verify_by' => $request->assigned_finance_id,
            ]);

            $this->addNotificationToUser(
                $request->assigned_finance_id,
                'Permintaan Validasi Finance',
                'PDC Admin telah meminta validasi untuk Project Improvement <span class="font-semibold">' . $project->title . '</span>.',
                'info'
            );

            return back()->with('success', 'Permintaan validasi Finance berhasil dikirim.');
        }

        return back()->with('error', 'Project tidak ditemukan.');
    }

    public function updateTopGaps(Request $request, $talent_id)
    {
        try {
            // Get priority IDs (Array of competence_id)
            $competence_ids = $request->input('competence_ids');
            $reason = $request->input('reason');

            // Get the latest assessment for the talent
            $latestAssessment = \App\Models\AssessmentSession::where('user_id_talent', $talent_id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestAssessment && is_array($competence_ids)) {
                // First reset all notes in the session to "Completed by talent" to remove old priorities
                \App\Models\DetailAssessment::where('assessment_id', $latestAssessment->id)
                    ->update(['notes' => 'Completed by talent']);

                // Set the priority to the selected ones
                foreach ($competence_ids as $index => $compId) {
                    $priority = $index + 1;
                    $noteValue = "priority_" . $priority . "|" . $reason;
                    \App\Models\DetailAssessment::where('assessment_id', $latestAssessment->id)
                        ->where('competence_id', $compId)
                        ->update(['notes' => $noteValue]);
                }
            }

            return response()->json(['success' => true]);
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PDCAdmin updateTopGaps error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function bodReview(Request $request)
    {
        $user = auth()->user();

        $query = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->whereHas('promotion_plan', fn($q) => $q->whereNotNull('target_position_id'))
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition', 'improvementProjects']);

        // Filters
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        if ($request->filled('position_id')) {
            $query->whereHas('promotion_plan', fn($q) => $q->where('target_position_id', $request->position_id));
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $talents = $query->get();

        // Stats
        $totalProjectImprovement = ImprovementProject::count();

        $belumDinilai = 0;
        $sudahDinilai = 0;

        foreach ($talents as $talent) {
            $alreadySent = in_array(
                optional($talent->promotion_plan)->status_promotion,
            ['Pending BOD', 'Approved BOD', 'Rejected BOD']
            );
            $isReviewedByBod = optional($talent->improvementProjects->sortByDesc('updated_at')->first())->bod_score !== null;

            if (optional($talent->promotion_plan)->status_promotion === 'Approved BOD') {
                $sudahDinilai++;
            }

            if ($alreadySent && !$isReviewedByBod) {
                $belumDinilai++;
            }
        }

        // Group by company -> target position -> talents
        $groupedData = $talents->groupBy('company_id')->map(function ($companyTalents) {
            return [
            'company' => $companyTalents->first()->company,
            'positions' => $companyTalents->groupBy(function ($item) {
                    return $item->promotion_plan->target_position_id ?? 0;
                }
                )->map(function ($positionTalents) {
                    return [
                    'targetPosition' => $positionTalents->first()->promotion_plan->targetPosition ?? null,
                    'talents' => $positionTalents,
                    ];
                }
                ),
                ];
            });

        $companies = Company::orderBy('nama_company')->get();
        $positions = Position::whereNotIn('position_name', ['Super Admin', 'Board of Directors'])->orderBy('grade_level')->get();
        $departments = Department::orderBy('nama_department')->get();

        return view('pdc_admin.bod-review', compact(
            'user', 'groupedData', 'companies', 'positions', 'departments',
            'totalProjectImprovement', 'belumDinilai', 'sudahDinilai'
        ));
    }

    public function bodReviewDetail($talent_id)
    {
        $user = auth()->user();

        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'promotion_plan.targetPosition',
            'improvementProjects',
        ])->findOrFail($talent_id);

        // All BOD users for building the evaluation table rows
        $bodUsers = User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bod', 'bo_director', 'board_of_directors', 'board_of_director']))
            ->with('company')
            ->orderBy('nama')
            ->get();

        // All companies for the table
        $companies = Company::orderBy('nama_company')->get();

        // Latest improvement project for this talent (for score/feedback)
        $latestProject = $talent->improvementProjects->sortByDesc('updated_at')->first();

        return view('pdc_admin.bod-review-detail', compact(
            'user', 'talent', 'bodUsers', 'companies', 'latestProject'
        ));
    }

    public function bodReviewComplete($talent_id)
    {
        $plan = PromotionPlan::where('user_id_talent', $talent_id)->firstOrFail();
        $plan->update(['status_promotion' => 'Approved BOD']);
        return redirect()->route('pdc_admin.bod_review')
            ->with('success', 'Proses penilaian BOD telah diselesaikan.');
    }

    public function sendBodReview(Request $request, $talent_id)
    {
        $plan = PromotionPlan::where('user_id_talent', $talent_id)->firstOrFail();
        if (!$plan->is_locked) {
            return back()->with('error', 'Progress harus dikunci terlebih dahulu sebelum dikirim ke BOD.');
        }
        $plan->update(['status_promotion' => 'Pending BOD']);
        return back()->with('success', 'Berhasil dikirim ke BOD untuk review.');
    }

    public function toggleLock($talent_id)
    {
        $plan = PromotionPlan::where('user_id_talent', $talent_id)->firstOrFail();
        $plan->update(['is_locked' => !$plan->is_locked]);
        $status = $plan->is_locked ? 'dikunci' : 'dibuka';
        return back()->with('success', "Progress talent berhasil $status.");
    }

    public function export()
    {
        $user = auth()->user();

        // Fetch all talents with promotion plans
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'Talent');
        })
            ->whereHas('promotion_plan')
            ->with(['company', 'department', 'position', 'promotion_plan.targetPosition'])
            ->get();

        // Group by target_position_id + company_id
        $groupedData = collect();
        foreach ($talents as $talent) {
            $pp = $talent->promotion_plan;
            if (!$pp)
                continue;

            $key = ($pp->target_position_id ?? 0) . '_' . ($talent->company_id ?? 0);

            if (!$groupedData->has($key)) {
                $groupedData[$key] = [
                    'targetPosition' => $pp->targetPosition,
                    'company' => $talent->company,
                    'talents' => collect(),
                ];
            }

            $groupedData[$key]['talents']->push($talent);
        }

        $companies = Company::orderBy('nama_company')->get();
        $positions = Position::whereNotIn('position_name', ['Super Admin', 'Board of Directors'])->orderBy('grade_level')->get();

        return view('pdc_admin.export', compact('user', 'groupedData', 'companies', 'positions'));
    }

    public function exportPdf($talent_id)
    {
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'promotion_plan.targetPosition',
            'assessmentSession.details.competence',
            'idpActivities.type',
            'improvementProjects.verifier',
        ])->findOrFail($talent_id);

        $competencies = Competence::all();
        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ?PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        $pdf = Pdf::loadView('pdc_admin.pdf_export', compact('talent', 'competencies', 'standards'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'Talent_Report_' . str_replace(' ', '_', $talent->nama) . '.pdf';
        return $pdf->download($filename);
    }

    public function assignRole(Request $request, $id)
    {
        $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:role,id'
        ]);

        $user = User::findOrFail($id);

        // Sync roles pivot table
        $user->roles()->sync($request->roles);

        // For backward compatibility, set the primary role_id 
        if (!empty($request->roles)) {
            $user->update(['role_id' => $request->roles[0]]);
        }

        return back()->with('success', 'Manajemen Role berhasil diperbarui.');
    }

    public function resetPassword($id)
    {
        $defaultPassword = 'Password123';

        DB::table('users')->where('id', $id)->update([
            'password' => \Illuminate\Support\Facades\Hash::make($defaultPassword),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Password user berhasil direset ke default.');
    }

    // ── Company Management ──────────────────────────────────────────
    public function companyManagement()
    {
        $user = auth()->user();
        $companies = Company::orderBy('nama_company')->get();
        return view('pdc_admin.company-management', compact('user', 'companies'));
    }

    public function storeCompany(Request $request)
    {
        $request->validate(['nama_company' => 'required|string|max:255']);
        Company::create(['nama_company' => $request->nama_company]);
        return back()->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function updateCompany(Request $request, $id)
    {
        $request->validate(['nama_company' => 'required|string|max:255']);
        Company::findOrFail($id)->update(['nama_company' => $request->nama_company]);
        return back()->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroyCompany($id)
    {
        Company::findOrFail($id)->delete();
        return back()->with('success', 'Perusahaan berhasil dihapus.');
    }

    public function departmentManagement($companyId)
    {
        $user = auth()->user();
        $company = Company::findOrFail($companyId);
        $departments = Department::where('company_id', $companyId)
            ->orderBy('nama_department')->get();
        return view('pdc_admin.department-management', compact('user', 'company', 'departments'));
    }

    public function updateDepartment(Request $request, $id)
    {
        $request->validate(['nama_department' => 'required|string|max:255']);
        Department::findOrFail($id)->update(['nama_department' => $request->nama_department]);
        return back()->with('success', 'Departemen berhasil diperbarui.');
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:company,id',
            'nama_department' => 'required|string|max:255',
        ]);
        Department::create([
            'company_id' => $request->company_id,
            'nama_department' => $request->nama_department,
        ]);
        return back()->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function destroyDepartment($id)
    {
        Department::findOrFail($id)->delete();
        return back()->with('success', 'Departemen berhasil dihapus.');
    }

    public function logbookDetail($id)
    {
        $user = auth()->user();
        $activity = \App\Models\IDPActivity::with(['talent', 'verifier', 'type'])->findOrFail($id);
        return view('pdc_admin.logbook-detail', compact('user', 'activity'));
    }
}
