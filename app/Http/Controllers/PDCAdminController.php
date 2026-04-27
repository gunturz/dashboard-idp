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
use Illuminate\Validation\ValidationException;

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
        $onProgressTalent = PromotionPlan::where('status_promotion', 'In Progress')
            ->whereNotNull('target_position_id')
            ->count();
        $pendingFinance = ImprovementProject::whereIn('status', ['Pending', 'On Progress'])->count();
        $pendingPanelis = PromotionPlan::where('status_promotion', 'Pending Panelis')->count();

        // Role statistics
        $roleCounts = [
            'Talent' => User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))->count(),
            'Mentor' => User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->count(),
            'Atasan' => User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->count(),
            'Finance' => User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))->count(),
            'Panelis' => User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bo_director', 'panelis', 'board_of_directors', 'board_of_director', 'panelis']))->count(),
        ];

        // Fetch the 5 most recent 'In Progress' talents with their relationships
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
            ->take(5)
            ->get();

        // Grouping: Company ID -> Target Position ID -> Talents
        $groupedData = $talents->groupBy('company_id')->map(function ($companyTalents) {
            return [
            'company' => $companyTalents->first()->company,
            'positions' => $companyTalents->groupBy(
                function ($item) {
                return $item->promotion_plan->target_position_id ?? 0;
            }
            )->map(
                function ($positionTalents) {
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

        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();
        $mentors = User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

        return view('pdc_admin.dashboard', compact(
            'user',
            'groupedData',
            'companies',
            'positions',
            'mentors',
            'atasans',
            'totalUsers',
            'onProgressTalent',
            'pendingFinance',
            'pendingPanelis',
            'roleCounts'
        ));
    }

    public function progressTalent()
    {
        $user = auth()->user();

        // Tampilkan talent yang SUDAH dibuatkan Development Plan oleh PDC Admin
        // (punya promotion_plan dengan target_position_id terpilih)
        // Sembunyikan yang belum punya plan atau sudah 'Approved Panelis'
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->whereHas('promotion_plan', function ($q) {
                $q->whereNotNull('target_position_id')
                    ->whereNotIn('status_promotion', ['Approved Panelis', 'Promoted', 'Not Promoted']);
            })
            ->join('promotion_plan', 'users.id', '=', 'promotion_plan.user_id_talent')
            ->select('users.*')
            ->orderBy('promotion_plan.created_at', 'desc')
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->get();

        // Grouping: Company ID -> Target Position ID -> Talents
        $groupedData = $talents->groupBy('company_id')
            ->map(function ($companyTalents) {
                $sortedCompanyTalents = $companyTalents->sortByDesc(function ($talent) {
                    return optional($talent->promotion_plan)->created_at ?? $talent->created_at;
                })->values();

            return [
                'company' => $sortedCompanyTalents->first()->company,
                'latest_plan_at' => $sortedCompanyTalents->max(function ($talent) {
                    return optional($talent->promotion_plan)->created_at ?? $talent->created_at;
                }),
                'positions' => $sortedCompanyTalents->groupBy(
                    function ($item) {
                        return $item->promotion_plan->target_position_id ?? 0;
                    }
                )->map(
                    function ($positionTalents) {
                        $sortedPositionTalents = $positionTalents->sortByDesc(function ($talent) {
                            return optional($talent->promotion_plan)->created_at ?? $talent->created_at;
                        })->values();

                        return [
                            'targetPosition' => $sortedPositionTalents->first()->promotion_plan->targetPosition ?? null,
                            'talents' => $sortedPositionTalents,
                        ];
                    }
                ),
            ];
            })
            ->sortByDesc('latest_plan_at');

        return view('pdc_admin.progress-talent', compact('user', 'groupedData'));
    }

    /**
     * Return talents filtered by company as JSON (for dynamic dropdown via fetch)
     */
    public function getTalentsByCompany(Request $request)
    {
        $companyId = $request->company_id;
        $departmentId = $request->department_id;
        $targetPositionId = $request->target_position_id;

        $query = User::query()
            ->whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->with('position:id,position_name,grade_level');

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($targetPositionId) {
            $sourcePositionId = $this->resolvePreviousPositionId((int) $targetPositionId);

            if ($sourcePositionId) {
                $query->where('position_id', $sourcePositionId);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $talents = $query
            ->orderBy('nama')
            ->get(['id', 'nama', 'position_id'])
            ->map(fn($talent) => [
                'id' => $talent->id,
                'nama' => $talent->nama,
                'position_id' => $talent->position_id,
                'position_name' => optional($talent->position)->position_name,
            ]);

        return response()->json($talents);
    }

    protected function resolvePreviousPositionId(int $targetPositionId): ?int
    {
        $targetPosition = Position::find($targetPositionId);
        if (!$targetPosition) {
            return null;
        }

        $normalizedTarget = $this->normalizePositionName($targetPosition->position_name);
        $orderedNames = [
            'staff',
            'supervisor',
            'officer',
            'manager',
            'general manager',
        ];

        $targetIndex = array_search($normalizedTarget, $orderedNames, true);
        if ($targetIndex !== false) {
            if ($targetIndex === 0) {
                return null;
            }

            $previousName = $orderedNames[$targetIndex - 1];

            return Position::query()
                ->get(['id', 'position_name'])
                ->first(fn($position) => $this->normalizePositionName($position->position_name) === $previousName)
                ?->id;
        }

        if ($targetPosition->grade_level !== null) {
            return Position::where('grade_level', '<', $targetPosition->grade_level)
                ->orderByDesc('grade_level')
                ->value('id');
        }

        return null;
    }

    protected function normalizePositionName(?string $name): string
    {
        $name = strtolower(trim((string) $name));
        $name = str_replace(['mgr', 'manajer', 'manager'], 'manager', $name);
        $name = str_replace(['gm', 'general manager'], 'general manager', $name);
        $name = preg_replace('/\s+/', ' ', $name);

        return $name;
    }

    /**
     * Save Development Plan submitted from PDC Admin dashboard
     */
    public function storeDevelopmentPlan(Request $request)
    {
        $this->persistDevelopmentPlan($request);

        return redirect()->route('pdc_admin.progress_talent')
            ->with('success', 'Development Plan berhasil disimpan!');
    }

    public function developmentPlan()
    {
        $user = auth()->user();
        $companies = Company::orderBy('nama_company')->get();
        $departments = Department::orderBy('nama_department')->get();

        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();
        $mentors = User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

        $editMode = false;
        $editingTalent = null;
        $prefillData = null;

        return view('pdc_admin.development-plan', compact(
            'user',
            'companies',
            'departments',
            'positions',
            'mentors',
            'atasans',
            'editMode',
            'editingTalent',
            'prefillData'
        ));
    }

    public function editDevelopmentPlan($company_id, $position_id)
    {
        $user = auth()->user();
        $companies = Company::orderBy('nama_company')->get();
        $departments = Department::orderBy('nama_department')->get();
        $departmentsByCompany = $departments
            ->groupBy('company_id')
            ->map(fn($items) => $items->map(fn($dept) => [
                'id' => $dept->id,
                'nama_department' => $dept->nama_department,
                'company_id' => $dept->company_id,
            ])->values())
            ->toArray();
        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();
        $mentors = User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

        $editingTalents = $this->getGroupedTalentsForPlan((int) $company_id, (int) $position_id);
        abort_if($editingTalents->isEmpty(), 404, 'Development Plan tidak ditemukan.');

        $editingTalent = $editingTalents->first();
        $plan = $editingTalent->promotion_plan;

        $editMode = true;
        $prefillData = [
            'company_id' => $editingTalent->company_id,
            'department_id' => $editingTalent->department_id,
            'target_position_id' => $plan->target_position_id,
            'atasan_id' => $editingTalent->atasan_id,
            'start_date' => optional($plan->start_date)->format('Y-m-d'),
            'target_date' => optional($plan->target_date)->format('Y-m-d'),
            'talents' => $editingTalents->map(function ($talent) {
                return [
                    'talent_id' => $talent->id,
                    'mentors' => collect(optional($talent->promotion_plan)->mentor_ids ?: [])
                        ->filter()
                        ->values()
                        ->all(),
                ];
            })->values()->all(),
            'group_company_id' => (int) $company_id,
            'group_position_id' => (int) $position_id,
        ];

        return view('pdc_admin.development-plan', compact(
            'user',
            'companies',
            'departments',
            'positions',
            'mentors',
            'atasans',
            'editMode',
            'editingTalent',
            'prefillData'
        ));
    }

    public function updateDevelopmentPlan(Request $request, $company_id, $position_id)
    {
        $editingTalents = $this->getGroupedTalentsForPlan((int) $company_id, (int) $position_id);
        abort_if($editingTalents->isEmpty(), 404, 'Development Plan tidak ditemukan.');

        $this->persistDevelopmentPlan($request, $editingTalents);

        return redirect()->route('pdc_admin.progress_talent')
            ->with('success', 'Development Plan berhasil diperbarui!');
    }

    public function destroyDevelopmentPlan($company_id, $position_id)
    {
        $talents = $this->getGroupedTalentsForPlan((int) $company_id, (int) $position_id);
        abort_if($talents->isEmpty(), 404, 'Development Plan tidak ditemukan.');

        DB::transaction(function () use ($talents) {
            foreach ($talents as $talent) {
                $talent->update([
                    'mentor_id' => null,
                    'atasan_id' => null,
                ]);

                $talent->promotion_plan()->delete();
            }
        });

        return redirect()->route('pdc_admin.progress_talent')
            ->with('success', 'Progress talent grup berhasil dihapus.');
    }

    protected function persistDevelopmentPlan(Request $request, $editingTalents = null): void
    {
        $request->validate([
            'company_id' => 'required|exists:company,id',
            'department_id' => 'nullable|exists:department,id',
            'target_position_id' => 'required|exists:position,id',
            'atasan_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'target_date' => 'required|date|after_or_equal:start_date',
            'talents' => 'required|array|min:1',
            'talents.*.talent_id' => 'required|exists:users,id',
            'talents.*.mentors' => 'required|array|min:1',
            'talents.*.mentors.*' => 'required|exists:users,id',
        ]);

        $sourcePositionId = $this->resolvePreviousPositionId((int) $request->target_position_id);
        if (!$sourcePositionId) {
            throw ValidationException::withMessages([
                'target_position_id' => 'Posisi yang dituju tidak memiliki urutan posisi sebelumnya yang valid.',
            ]);
        }

        $selectedTalentIds = collect($request->talents)
            ->pluck('talent_id')
            ->filter()
            ->values();

        $editingTalentIds = collect($editingTalents)->pluck('id')->map(fn($id) => (string) $id)->values();
        $isEditMode = $editingTalentIds->isNotEmpty();

        if ($isEditMode && $selectedTalentIds->isEmpty()) {
            throw ValidationException::withMessages([
                'talents' => 'Minimal harus ada satu talent dalam grup.',
            ]);
        }

        $validTalentIds = User::query()
            ->whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->where('company_id', $request->company_id)
            ->when($request->filled('department_id'), fn($q) => $q->where('department_id', $request->department_id))
            ->where('position_id', $sourcePositionId)
            ->whereIn('id', $selectedTalentIds)
            ->pluck('id');

        if ($validTalentIds->count() !== $selectedTalentIds->count()) {
            throw ValidationException::withMessages([
                'talents' => 'Talent yang dipilih harus sesuai perusahaan, departemen, dan urutan posisi sebelum posisi target.',
            ]);
        }

        $validAtasan = User::query()
            ->where('id', $request->atasan_id)
            ->whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))
            ->where('company_id', $request->company_id)
            ->when($request->filled('department_id'), fn($q) => $q->where('department_id', $request->department_id))
            ->exists();

        if (!$validAtasan) {
            throw ValidationException::withMessages([
                'atasan_id' => 'Atasan harus sesuai perusahaan dan departemen yang dipilih.',
            ]);
        }

        $selectedMentorIds = collect($request->talents)
            ->pluck('mentors')
            ->flatten()
            ->filter()
            ->unique()
            ->values();

        $validMentorIds = User::query()
            ->whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))
            ->where('company_id', $request->company_id)
            ->when($request->filled('department_id'), fn($q) => $q->where('department_id', $request->department_id))
            ->whereIn('id', $selectedMentorIds)
            ->pluck('id');

        if ($validMentorIds->count() !== $selectedMentorIds->count()) {
            throw ValidationException::withMessages([
                'talents' => 'Mentor yang dipilih harus sesuai perusahaan dan departemen yang dipilih.',
            ]);
        }

        DB::transaction(function () use ($request, $editingTalentIds, $selectedTalentIds, $isEditMode) {
            if ($isEditMode) {
                $removedTalentIds = $editingTalentIds
                    ->diff($selectedTalentIds->map(fn($id) => (string) $id));

                if ($removedTalentIds->isNotEmpty()) {
                    User::whereIn('id', $removedTalentIds->all())->update([
                        'mentor_id' => null,
                        'atasan_id' => null,
                    ]);

                    PromotionPlan::whereIn('user_id_talent', $removedTalentIds->all())->delete();
                }
            }

            foreach ($request->talents as $talentData) {
                $talentId = $talentData['talent_id'];
                $mentorIds = collect($talentData['mentors'])
                    ->filter()
                    ->values()
                    ->all();
                $primaryMentorId = $mentorIds[0] ?? null;

                User::where('id', $talentId)->update([
                    'mentor_id' => $primaryMentorId,
                    'atasan_id' => $request->atasan_id,
                ]);

                PromotionPlan::updateOrCreate(
                    ['user_id_talent' => $talentId],
                    [
                        'target_position_id' => $request->target_position_id,
                        'mentor_ids' => $mentorIds,
                        'status_promotion' => 'In Progress',
                        'start_date' => $request->start_date,
                        'target_date' => $request->target_date,
                    ]
                );
            }
        });
    }

    protected function getGroupedTalentsForPlan(int $companyId, int $positionId)
    {
        return User::where('company_id', $companyId)
            ->whereHas('promotion_plan', function ($q) use ($positionId) {
                $q->where('target_position_id', $positionId);
            })
            ->with(['promotion_plan', 'department'])
            ->orderBy('nama')
            ->get();
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
            ->with(['department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
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

    public function talentLogbook($talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'promotion_plan.targetPosition',
        ])->findOrFail($talent_id);

        $activities = \App\Models\IDPActivity::with(['type', 'verifier'])
            ->where('user_id_talent', $talent->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $exposureData = [];
        $mentoringData = [];
        $learningData = [];

        foreach ($activities as $act) {
            $typeName = $act->type?->type_name ?? '';

            if ($typeName === 'Exposure') {
                $exposureData[] = [
                    'id' => $act->id,
                    'mentor' => $act->verifier?->nama ?? '-',
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'status' => $act->status,
                ];
            } elseif ($typeName === 'Mentoring') {
                $mentoringData[] = [
                    'id' => $act->id,
                    'mentor' => $act->verifier?->nama ?? '-',
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'status' => $act->status,
                ];
            } elseif ($typeName === 'Learning') {
                $learningData[] = [
                    'id' => $act->id,
                    'sumber' => $act->activity,
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'status' => $act->status,
                ];
            }
        }

        return view('pdc_admin.logbook', compact(
            'user',
            'talent',
            'exposureData',
            'mentoringData',
            'learningData'
        ));
    }

    public function financeValidation()
    {
        $user = auth()->user();

        $projects = ImprovementProject::with([
            'talent.position',
            'talent.department',
            'talent.promotion_plan.targetPosition',
        ])
            ->whereHas('talent.promotion_plan', function ($q) {
                $q->whereNotIn('status_promotion', ['Promoted', 'Not Promoted']);
            })
            ->orderByRaw("FIELD(status, 'Pending', 'On Progress', 'Verified', 'Rejected')")
            ->orderBy('created_at', 'desc')
            ->get();

        $total = $projects->count();
        $pending = $projects->whereIn('status', ['Pending', 'On Progress'])->count();
        $approved = $projects->where('status', 'Verified')->count();
        $rejected = $projects->where('status', 'Rejected')->count();

        $financeUsers = \App\Models\User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))->get();

        return view('pdc_admin.finance-validation', compact('user', 'projects', 'total', 'pending', 'approved', 'rejected', 'financeUsers'));
    }

    public function updateFinanceValidation(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Verified,Rejected']);

        $project = ImprovementProject::findOrFail($id);

        $updateData = [
            'status' => $request->status,
            'verify_by' => auth()->id(),
            'verify_at' => now(),
        ];

        // Simpan feedback PDC Admin jika diisi (tambahkan ke kolom 'feedback' agar tidak menghapus 'finance_feedback')
        if ($request->filled('pdc_feedback')) {
            $existing = $project->feedback ? $project->feedback . "\n\n" : "";
            $updateData['feedback'] = $existing . "[Admin PDC: " . $request->pdc_feedback . "]";
        }

        $project->update($updateData);

        $feedbackNote = $request->filled('pdc_feedback')
            ? ' Catatan: <em>' . e($request->pdc_feedback) . '</em>'
            : '';

        $this->addNotificationToUser(
            $project->user_id_talent,
            'Project ' . $request->status,
            'Project Improvement Anda telah diperbarui menjadi <span class="font-semibold">' . $request->status . '</span> oleh PDC Admin.' . $feedbackNote,
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

        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();

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
        })->with(['position', 'department', 'company'])->latest()->get();

        $mentors = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'mentor');
        })->with(['position', 'department', 'company'])->latest()->get();

        $finances = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'finance');
        })->with(['position', 'department', 'company'])->latest()->get();

        $panelisUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('role_name', ['bo_director', 'panelis', 'board_of_directors', 'board_of_director', 'panelis']);
        })->with(['position', 'department', 'company'])->latest()->get();

        $atasans = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'atasan');
        })->with(['position', 'department', 'company'])->latest()->get();

        $departments = Department::orderBy('nama_department')->get();
        $departmentsByCompany = $departments
            ->groupBy('company_id')
            ->map(fn($items) => $items->map(fn($dept) => [
                'id' => $dept->id,
                'nama_department' => $dept->nama_department,
                'company_id' => $dept->company_id,
            ])->values())
            ->toArray();
        $positions = Position::all();
        $rolesData = Role::all(); // Provide all roles for the assign modal
        $companies = Company::orderBy('nama_company')->get();

        return view('pdc_admin.user-management', compact('user', 'talents', 'mentors', 'finances', 'panelisUsers', 'atasans', 'departments', 'departmentsByCompany', 'positions', 'rolesData', 'companies'));
    }

    public function destroyUser($id)
    {
        $targetUser = User::findOrFail($id);

        // Cek jika user yang akan dihapus adalah super admin / diri sendiri
        if ($targetUser->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($targetUser) {
            $id = $targetUser->id;

            // Nullify Atasan/Mentor assignments pada user lain
            User::where('atasan_id', $id)->update(['atasan_id' => null]);
            User::where('mentor_id', $id)->update(['mentor_id' => null]);

            // Untuk Project & Aktivitas yang divalidasi oleh HR/Finance/Atasan
            \App\Models\ImprovementProject::where('verify_by', $id)->update(['verify_by' => null]);
            \App\Models\IdpActivity::where('verify_by', $id)->update(['verify_by' => null]);
            \App\Models\AssessmentSession::where('user_id_atasan', $id)->update(['user_id_atasan' => null]);

            // Hapus session jika dia adalah talent (ini akan butuh hapus details dulu)
            $sessions = \App\Models\AssessmentSession::where('user_id_talent', $id)->get();
            foreach ($sessions as $session) {
                \App\Models\DetailAssessment::where('assessment_id', $session->id)->delete();
                $session->delete();
            }

            // Hapus data yang dependen langsung karena dia sebagai Talent
            \App\Models\ImprovementProject::where('user_id_talent', $id)->delete();
            \App\Models\IdpActivity::where('user_id_talent', $id)->delete();
            \App\Models\PanelisAssessment::where('user_id_talent', $id)->delete();
            \App\Models\PromotionPlan::where('user_id_talent', $id)->delete();

            // Jika user adalah Panelis
            \App\Models\PanelisAssessment::where('panelis_id', $id)->delete();

            // Hapus role (pivot)
            $targetUser->roles()->detach();

            // Hapus data dependen lainnya
            \Illuminate\Support\Facades\DB::table('password_resets')->where('user_id', $id)->delete();

            // Selesaikan hapus
            $targetUser->delete();
        });

        return back()->with('success', 'User berhasil dihapus beserta data terkait.');
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

    public function panelisReview(Request $request)
    {
        $user = auth()->user();

        $query = User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->whereHas('promotion_plan', fn($q) => $q->whereNotNull('target_position_id')
        ->whereNotIn('status_promotion', ['Approved Panelis', 'Promoted', 'Not Promoted']))
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

        $talents = $query->get()
            ->sortByDesc(function ($talent) {
                return optional($talent->improvementProjects->sortByDesc('created_at')->first())->created_at
                    ?? optional($talent->promotion_plan)->created_at
                    ?? $talent->created_at;
            })
            ->values();

        // Stats
        $totalProjectImprovement = ImprovementProject::count();

        $belumDinilai = 0;
        $sudahDinilai = 0;

        foreach ($talents as $talent) {
            $alreadySent = in_array(
                optional($talent->promotion_plan)->status_promotion,
            ['Pending Panelis', 'Approved Panelis', 'Rejected Panelis']
            );
            $isReviewedByPanelis = \App\Models\PanelisAssessment::where('user_id_talent', $talent->id)->exists();

            if (in_array(optional($talent->promotion_plan)->status_promotion, ['Approved Panelis', 'Promoted', 'Not Promoted'])) {
                $sudahDinilai++;
            }

            if ($alreadySent && !$isReviewedByPanelis) {
                $belumDinilai++;
            }
        }

        // Group by company -> target position -> talents
        $groupedData = $talents->groupBy('company_id')
            ->map(function ($companyTalents) {
                $sortedCompanyTalents = $companyTalents->sortByDesc(function ($talent) {
                    return optional($talent->improvementProjects->sortByDesc('created_at')->first())->created_at
                        ?? optional($talent->promotion_plan)->created_at
                        ?? $talent->created_at;
                })->values();

            return [
                'company' => $sortedCompanyTalents->first()->company,
                'latest_project_at' => $sortedCompanyTalents->max(function ($talent) {
                    return optional($talent->improvementProjects->sortByDesc('created_at')->first())->created_at
                        ?? optional($talent->promotion_plan)->created_at
                        ?? $talent->created_at;
                }),
                'positions' => $sortedCompanyTalents->groupBy(
                    function ($item) {
                        return $item->promotion_plan->target_position_id ?? 0;
                    }
                )->map(
                    function ($positionTalents) {
                        $sortedPositionTalents = $positionTalents->sortByDesc(function ($talent) {
                            return optional($talent->improvementProjects->sortByDesc('created_at')->first())->created_at
                                ?? optional($talent->promotion_plan)->created_at
                                ?? $talent->created_at;
                        })->values();

                        return [
                            'targetPosition' => $sortedPositionTalents->first()->promotion_plan->targetPosition ?? null,
                            'talents' => $sortedPositionTalents,
                        ];
                    }
                ),
            ];
            })
            ->sortByDesc('latest_project_at');

        $companies = Company::orderBy('nama_company')->get();
        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();
        $departments = Department::orderBy('nama_department')->get();
        $allDepartments = $departments
            ->map(fn($dept) => [
                'id' => $dept->id,
                'nama_department' => $dept->nama_department,
                'company_id' => $dept->company_id,
            ])
            ->values()
            ->toArray();
        $departmentsByCompany = $departments
            ->groupBy('company_id')
            ->map(fn($items) => $items->map(fn($dept) => [
                'id' => $dept->id,
                'nama_department' => $dept->nama_department,
                'company_id' => $dept->company_id,
            ])->values())
            ->toArray();

        $panelisUsers = User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bo_director', 'panelis', 'board_of_directors', 'board_of_director']))
            ->with(['company', 'position'])
            ->orderBy('nama')
            ->get();
        $panelisCompanies = $panelisUsers->pluck('company')->unique('id')->filter()->values();

        return view('pdc_admin.panelis-review', compact(
            'user',
            'groupedData',
            'companies',
            'positions',
            'departments',
            'allDepartments',
            'departmentsByCompany',
            'totalProjectImprovement',
            'belumDinilai',
            'sudahDinilai',
            'panelisUsers',
            'panelisCompanies'
        ));
    }

    public function panelisReviewDetail($talent_id)
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

        // All Panelis users for building the evaluation table rows
        $panelisUsers = User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['panelis', 'bo_director', 'board_of_directors', 'board_of_director', 'panelis']))
            ->with('company')
            ->orderBy('nama')
            ->get();

        // All companies for the table
        $companies = Company::orderBy('nama_company')->get();

        // Latest improvement project for this talent (for score/feedback)
        $latestProject = $talent->improvementProjects->sortByDesc('updated_at')->first();

        return view('pdc_admin.panelis-review-detail', compact(
            'user',
            'talent',
            'panelisUsers',
            'companies',
            'latestProject'
        ));
    }

    public function panelisReviewComplete(Request $request, $talent_id)
    {
        $request->validate([
            'decision' => 'required|in:promoted,not_promoted',
        ]);

        $plan = PromotionPlan::where('user_id_talent', $talent_id)->firstOrFail();
        $talent = User::findOrFail($talent_id);
        $targetPosition = optional($plan->targetPosition)->position_name ?? 'posisi yang dituju';

        if ($request->decision === 'promoted') {
            $plan->update(['status_promotion' => 'Promoted']);

            // Otomatis memperbarui posisi user (talent) ke posisi yang dituju
            $talent->update(['position_id' => $plan->target_position_id]);

            $this->addNotificationToUser(
                $talent_id,
                '🎉 Selamat! Anda Resmi Diangkat',
                'PDC Admin telah memutuskan bahwa Anda <span class="font-semibold text-green-600">berhasil diangkat</span> ke posisi <span class="font-semibold">' . $targetPosition . '</span>. Selamat atas pencapaian luar biasa ini!',
                'success'
            );

            $message = 'Talent ' . $talent->nama . ' berhasil diangkat ke ' . $targetPosition . '.';
        } else {
            $plan->update(['status_promotion' => 'Not Promoted']);

            $this->addNotificationToUser(
                $talent_id,
                'Hasil Keputusan Promosi',
                'PDC Admin telah menyelesaikan proses evaluasi Anda. Berdasarkan hasil penilaian, Anda <span class="font-semibold text-amber-600">belum diangkat</span> ke posisi <span class="font-semibold">' . $targetPosition . '</span> pada periode ini. Terus tingkatkan kompetensi Anda!',
                'warning'
            );

            $message = 'Keputusan tidak diangkat untuk ' . $talent->nama . ' telah disimpan.';
        }

        // --- RESET PROGRESS (ARCHIVE) ---
        // Sembunyikan progress dari dashboard aktif agar bisa mulai progress baru di masa depan
        $talent->promotion_plan()->update(['is_active' => false]);
        $talent->assessmentSession()->update(['is_active' => false]);
        $talent->idpActivities()->update(['is_active' => false]);
        $talent->improvementProjects()->update(['is_active' => false]);
        $talent->panelisAssessments()->update(['is_active' => false]);

        return redirect()->route('pdc_admin.export')->with('success', $message);
    }

    public function sendPanelisReview(Request $request, $talent_id)
    {
        $plan = PromotionPlan::where('user_id_talent', $talent_id)->firstOrFail();
        if (!$plan->is_locked) {
            return back()->with('error', 'Progress harus dikunci terlebih dahulu sebelum dikirim ke Panelis.');
        }

        $request->validate([
            'panelis_ids' => 'required|array|min:1',
            'panelis_ids.*' => 'exists:users,id'
        ]);

        foreach ($request->panelis_ids as $panelis_id) {
            \App\Models\PanelisAssessment::updateOrCreate([
                'user_id_talent' => $talent_id,
                'panelis_id' => $panelis_id,
            ]);
        }

        $plan->update(['status_promotion' => 'Pending Panelis']);
        return back()->with('success', 'Berhasil dikirim ke Panelis untuk review.');
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

        // Specific order as requested by user
        $desiredOrder = [
            'PT. Tiga Serangkai Inti Corpora',
            'PT. Tiga Serangkai Pustaka Mandiri',
            'PT. Wangsa Jatra Lestari',
            'PT. K33 Distribusi',
            'Assalam Hypermarket'
        ];

        $companies = Company::all()->sortBy(function ($company) use ($desiredOrder) {
            $pos = array_search($company->nama_company, $desiredOrder);
            return $pos !== false ? $pos : 999;
        });

        // Fetch talents whose promotion process is completed (Promoted or Not Promoted)
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'Talent');
        })
            ->whereHas('all_promotion_plans', function ($q) {
            $q->where('is_active', false)->whereIn('status_promotion', ['Promoted', 'Not Promoted']);
        })
            ->with(['company', 'department', 'position', 'all_promotion_plans' => function($q) {
                $q->where('is_active', false)->whereIn('status_promotion', ['Promoted', 'Not Promoted']);
            }, 'all_improvementProjects'])
            ->get();

        // Initialize groupedData with ALL companies
        $groupedData = collect();
        foreach ($companies as $comp) {
            $groupedData[$comp->id] = [
                'company' => $comp,
                'talents' => collect(),
            ];
        }

        // Populate talents into the initialized groups
        foreach ($talents as $talent) {
            $company_id = $talent->company_id;
            if ($company_id && $groupedData->has($company_id)) {
                $groupedData[$company_id]['talents']->push($talent);
            }
        }

        // Attach panelis review status manually to avoid huge queries
        $panelisAssessedTalentIds = \App\Models\PanelisAssessment::whereIn('user_id_talent', $talents->pluck('id'))->pluck('user_id_talent')->toArray();

        foreach ($talents as $talent) {
            // Map archived plans to original properties for view compatibility
            $talent->promotion_plan = $talent->all_promotion_plans->first();
            $talent->improvementProjects = $talent->all_improvementProjects;
            $talent->is_reviewed_by_panelis = in_array($talent->id, $panelisAssessedTalentIds);
        }

        return view('pdc_admin.export', compact('user', 'groupedData', 'companies'));
    }

    public function exportDetail($talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'all_promotion_plans.targetPosition',
            'all_assessmentSessions.details.competence',
            'all_idpActivities.type',
            'all_improvementProjects.verifier',
            'all_panelisAssessments.panelis.company',
            'all_panelisAssessments.panelis.position'
        ])->findOrFail($talent_id);

        // Map archived progress to original properties for view compatibility
        $talent->promotion_plan = $talent->all_promotion_plans->first();
        $talent->assessmentSession = $talent->all_assessmentSessions->first();
        $talent->idpActivities = $talent->all_idpActivities;
        $talent->improvementProjects = $talent->all_improvementProjects;
        $talent->panelisAssessments = $talent->all_panelisAssessments;

        $competencies = Competence::all();

        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ?PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        // Build top 3 GAP list
        $sess = $talent->assessmentSession;
        $gaps = collect();
        if ($sess && $sess->details->count()) {
            $overrides = $sess->details->filter(fn($d) => str_starts_with($d->notes ?? '', 'priority_'))
                ->sortBy(fn($d) => (int)explode('|', str_replace('priority_', '', $d->notes))[0]);
            $gaps = $overrides->count() > 0
                ? $overrides->values()
                : $sess->details->sortBy('gap_score')->take(3)->values();
        }

        // IDP activity counts
        $exposureCount = 0;
        $mentoringCount = 0;
        $learningCount = 0;
        if ($talent->idpActivities) {
            foreach ($talent->idpActivities as $act) {
                $typeName = strtolower(optional($act->type)->type_name ?? '');
                if (str_contains($typeName, 'exposure'))
                    $exposureCount++;
                elseif (str_contains($typeName, 'mentor'))
                    $mentoringCount++;
                elseif (str_contains($typeName, 'learn'))
                    $learningCount++;
            }
        }

        return view('pdc_admin.export_detail', compact(
            'user',
            'talent',
            'competencies',
            'standards',
            'gaps',
            'exposureCount',
            'mentoringCount',
            'learningCount'
        ));
    }


    public function exportPdf($talent_id)
    {
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'all_promotion_plans.targetPosition',
            'all_assessmentSessions.details.competence',
            'all_idpActivities.type',
            'all_improvementProjects.verifier',
            'all_panelisAssessments.panelis.company',
            'all_panelisAssessments.panelis.position'
        ])->findOrFail($talent_id);

        // Map archived progress to original properties for view compatibility
        $talent->promotion_plan = $talent->all_promotion_plans->first();
        $talent->assessmentSession = $talent->all_assessmentSessions->first();
        $talent->idpActivities = $talent->all_idpActivities;
        $talent->improvementProjects = $talent->all_improvementProjects;
        $talent->panelisAssessments = $talent->all_panelisAssessments;

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
        try {
            // Cek apakah ada User yang masih terdaftar di Perusahaan ini
            $userCount = User::where('company_id', $id)->count();
            if ($userCount > 0) {
                return back()->with('error', "Gagal menghapus! Terdapat {$userCount} akun pengguna (Talent/Admin/dll) di Perusahaan ini. Pastikan kosong sebelum dihapus.");
            }

            DB::transaction(function () use ($id) {
                // Hapus semua departemen yang menginduk ke perusahaan ini
                Department::where('company_id', $id)->delete();

                // Hapus perusahaannya
                Company::findOrFail($id)->delete();
            });

            return back()->with('success', 'Perusahaan beserta seluruh Departemen di dalamnya berhasil dihapus.');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
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
        try {
            // Cek apakah ada User yang masih terdaftar di Departemen ini
            $userCount = User::where('department_id', $id)->count();
            if ($userCount > 0) {
                return back()->with('error', "Gagal menghapus! Terdapat {$userCount} akun pengguna di Departemen ini. Pindahkan atau hapus akun mereka terlebih dahulu.");
            }

            Department::findOrFail($id)->delete();
            return back()->with('success', 'Departemen berhasil dihapus.');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function logbookDetail($id)
    {
        $user = auth()->user();
        $activity = \App\Models\IDPActivity::with(['talent', 'verifier', 'type'])->findOrFail($id);
        return view('pdc_admin.logbook-detail', compact('user', 'activity'));
    }
}
