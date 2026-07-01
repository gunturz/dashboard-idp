<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;
use App\Models\PromotionPlan;
use App\Models\DevelopmentSession;
use App\Models\ImprovementProject;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class PDCAdminController extends Controller
{
    protected function formatPlanPeriod(?string $startDate, ?string $targetDate): string
    {
        if (!$startDate || !$targetDate) {
            return '-';
        }

        return Carbon::parse($startDate)->locale('id')->translatedFormat('d F Y') . ' - ' . Carbon::parse($targetDate)->locale('id')->translatedFormat('d F Y');
    }

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

        // Role statistics
        $roleCounts = [
            'Talent' => User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))->count(),
            'Mentor' => User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->count(),
            'Atasan' => User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->count(),
            'Finance' => User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))->count(),
            'Panelis' => User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bo_director', 'panelis', 'board_of_directors', 'board_of_director', 'panelis']))->count(),
        ];

        // Summary Cards
        $totalUsers = array_sum($roleCounts);
        $onProgressTalent = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })->whereHas('promotion_plan', function ($q) {
            $q->whereNotNull('target_position_id')
                ->whereNotIn('status_promotion', ['Approved Panelis', 'Promoted', 'Not Promoted']);
        })->count();
        $pendingFinance = ImprovementProject::where('is_active', true)
            ->whereHas('talent.promotion_plan', function ($q) {
                $q->whereNotIn('status_promotion', ['Promoted', 'Not Promoted']);
            })->where(function ($q) {
                $q->whereNull('finance_feedback')
                    ->orWhere(function ($q2) {
                        $q2->where('finance_feedback', 'not like', '[Approved]%')
                            ->where('finance_feedback', 'not like', '[Rejected]%');
                    });
            })->count();
        $pendingPanelis = PromotionPlan::where('status_promotion', 'Pending Panelis')->count();
        $progressCompleted = PromotionPlan::where('is_active', false)
            ->whereIn('status_promotion', ['Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'])
            ->whereHas('talent', function ($q) {
                $q->whereHas('roles', function ($q2) {
                    $q2->where('role_name', 'Talent');
                });
            })
            ->count();

        // Fetch the 8 most recent talents whose development plan is still active
        // Menampilkan semua talent yang sedang aktif dalam siklus promosi (belum Promoted/Not Promoted)
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->whereHas('promotion_plan', function ($q) {
                $q->whereNotNull('target_position_id')
                    ->whereNotIn('status_promotion', ['Promoted', 'Not Promoted'])
                    ->where('is_active', true);
            })
            ->join('promotion_plan', function ($join) {
                $join->on('users.id', '=', 'promotion_plan.user_id_talent')
                    ->where('promotion_plan.is_active', true);
            })
            ->select('users.*')
            ->orderBy('promotion_plan.updated_at', 'desc')
            ->orderBy('promotion_plan.created_at', 'desc')
            ->with(['company', 'department', 'position', 'mentor', 'atasan', 'promotion_plan.targetPosition'])
            ->take(8)
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
        $mentors = User::with('position:id,grade_level')->whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::with('position:id,grade_level')->whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

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
            'progressCompleted',
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
            $sourcePositionIds = $this->resolvePreviousPositionIds((int) $targetPositionId);

            if (empty($sourcePositionIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('position_id', $sourcePositionIds);
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
                'grade_level' => optional($talent->position)->grade_level,
            ]);

        return response()->json($talents);
    }

    /**
     * Returns an array of valid source position IDs for the given target position ID.
     *
     * Aturan:
     * - Supervisor atau Officer  → source: [Staff]
     * - Manager                  → source: [Supervisor, Officer]
     * - General Manager          → source: [Manager]
     */
    protected function resolvePreviousPositionIds(int $targetPositionId): array
    {
        $targetPosition = Position::find($targetPositionId);
        if (!$targetPosition) {
            return [];
        }

        $normalizedTarget = $this->normalizePositionName($targetPosition->position_name);

        // Supervisor / Officer → cari semua talent berposisi Staff
        if (in_array($normalizedTarget, ['supervisor', 'officer'], true)) {
            return Position::get(['id', 'position_name'])
                ->filter(fn($p) => $this->normalizePositionName($p->position_name) === 'staff')
                ->pluck('id')
                ->values()
                ->all();
        }

        // Manager → cari talent berposisi Supervisor ATAU Officer
        if ($normalizedTarget === 'manager') {
            return Position::get(['id', 'position_name'])
                ->filter(fn($p) => in_array(
                    $this->normalizePositionName($p->position_name),
                    ['supervisor', 'officer'],
                    true
                ))
                ->pluck('id')
                ->values()
                ->all();
        }

        // General Manager → cari talent berposisi Manager
        if ($normalizedTarget === 'general manager') {
            return Position::get(['id', 'position_name'])
                ->filter(fn($p) => $this->normalizePositionName($p->position_name) === 'manager')
                ->pluck('id')
                ->values()
                ->all();
        }

        // Fallback: cari berdasarkan grade_level lebih rendah satu tingkat
        if ($targetPosition->grade_level !== null) {
            $ids = Position::where('grade_level', '<', $targetPosition->grade_level)
                ->orderByDesc('grade_level')
                ->limit(1)
                ->pluck('id')
                ->all();
            return $ids;
        }

        return [];
    }

    /** @deprecated Gunakan resolvePreviousPositionIds() — dipertahankan untuk backward compatibility */
    protected function resolvePreviousPositionId(int $targetPositionId): ?int
    {
        $ids = $this->resolvePreviousPositionIds($targetPositionId);
        return $ids[0] ?? null;
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
        $companies = Company::orderByRaw("
            CASE 
                WHEN nama_company LIKE '%Inti corpora%' THEN 1
                WHEN nama_company LIKE '%Pustaka mandiri%' THEN 2
                WHEN nama_company LIKE '%Wangsa Jatra Lestari%' THEN 3
                WHEN nama_company LIKE '%Assalam Niaga Utama%' THEN 4
                WHEN nama_company LIKE '%K33 Distribusi%' THEN 5
                ELSE 6 
            END ASC
        ")->orderBy('nama_company')->get();
        $departments = Department::orderBy('nama_department')->get();

        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();
        $mentors = User::with('position:id,grade_level')->whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::with('position:id,grade_level')->whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

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
        // $companies = Company::orderBy('nama_company')->get();
        $companies = Company::orderByRaw("
            CASE 
                WHEN nama_company LIKE '%Inti corpora%' THEN 1
                WHEN nama_company LIKE '%Pustaka mandiri%' THEN 2
                WHEN nama_company LIKE '%Wangsa Jatra Lestari%' THEN 3
                WHEN nama_company LIKE '%Assalam Niaga Utama%' THEN 4
                WHEN nama_company LIKE '%K33 Distribusi%' THEN 5
                ELSE 6 
            END ASC
        ")->orderBy('nama_company')->get();
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
        $mentors = User::with('position:id,grade_level')->whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->orderBy('nama')->get();
        $atasans = User::with('position:id,grade_level')->whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->orderBy('nama')->get();

        $departmentId = request()->query('department_id');
        $planCreatedAt = request()->query('plan_created_at');
        $editingTalents = $this->getGroupedTalentsForPlan(
            (int) $company_id,
            (int) $position_id,
            $departmentId ? (int) $departmentId : null,
            $planCreatedAt
        );
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
            'group_department_id' => $editingTalent->department_id,
            'group_plan_created_at' => optional($plan->created_at)?->format('Y-m-d H:i:s'),
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
        $departmentId = $request->query('department_id');
        $planCreatedAt = $request->query('plan_created_at');
        $editingTalents = $this->getGroupedTalentsForPlan(
            (int) $company_id,
            (int) $position_id,
            $departmentId ? (int) $departmentId : null,
            $planCreatedAt
        );
        abort_if($editingTalents->isEmpty(), 404, 'Development Plan tidak ditemukan.');

        $this->persistDevelopmentPlan($request, $editingTalents);

        return redirect()->route('pdc_admin.progress_talent')
            ->with('success', 'Development Plan berhasil diperbarui!');
    }

    public function destroyDevelopmentPlan($company_id, $position_id)
    {
        $departmentId = request()->query('department_id');
        $planCreatedAt = request()->query('plan_created_at');
        $talents = $this->getGroupedTalentsForPlan(
            (int) $company_id,
            (int) $position_id,
            $departmentId ? (int) $departmentId : null,
            $planCreatedAt
        );
        abort_if($talents->isEmpty(), 404, 'Development Plan tidak ditemukan.');

        DB::transaction(function () use ($talents) {
            foreach ($talents as $talent) {
                $talent->update([
                    'mentor_id' => null,
                    'atasan_id' => null,
                ]);

                $plan = $talent->promotion_plan()->first();
                if ($plan && $plan->development_session_id) {
                    $sessionId = $plan->development_session_id;
                    \App\Models\DevelopmentSession::where('id', $sessionId)->update(['is_active' => false, 'status' => 'Removed', 'completed_at' => now()]);
                    \App\Models\PromotionPlan::where('development_session_id', $sessionId)->update(['is_active' => false]);
                    \App\Models\AssessmentSession::where('development_session_id', $sessionId)->update(['is_active' => false]);
                    \App\Models\IdpActivity::where('development_session_id', $sessionId)->update(['is_active' => false]);
                    \App\Models\ImprovementProject::where('development_session_id', $sessionId)->update(['is_active' => false]);
                    \App\Models\PanelisAssessment::where('development_session_id', $sessionId)->update(['is_active' => false]);
                } else {
                    $talent->promotion_plan()->update(['is_active' => false]);
                    $talent->assessmentSession()->update(['is_active' => false]);
                    $talent->idpActivities()->update(['is_active' => false]);
                    $talent->improvementProjects()->update(['is_active' => false]);
                    $talent->panelisAssessments()->update(['is_active' => false]);
                }
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

        $sourcePositionIds = $this->resolvePreviousPositionIds((int) $request->target_position_id);
        if (empty($sourcePositionIds)) {
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
            ->whereIn('position_id', $sourcePositionIds)
            ->whereIn('id', $selectedTalentIds)
            ->pluck('id');

        if ($validTalentIds->count() !== $selectedTalentIds->count()) {
            throw ValidationException::withMessages([
                'talents' => 'Talent yang dipilih harus sesuai perusahaan, departemen, dan urutan posisi sebelum posisi target.',
            ]);
        }

        $selectedTalentPositions = User::query()
            ->with('position:id,grade_level')
            ->whereIn('id', $selectedTalentIds)
            ->get(['id', 'position_id'])
            ->keyBy('id');

        $minimumAtasanGrade = $selectedTalentPositions
            ->map(fn($talent) => optional($talent->position)->grade_level)
            ->filter(fn($grade) => $grade !== null)
            ->max();

        $validAtasan = User::query()
            ->where('id', $request->atasan_id)
            ->whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))
            ->where('company_id', $request->company_id)
            ->when($request->filled('department_id'), fn($q) => $q->where('department_id', $request->department_id))
            ->when($minimumAtasanGrade !== null, fn($q) => $q->whereHas('position', fn($positionQuery) => $positionQuery->where('grade_level', '>', $minimumAtasanGrade)))
            ->exists();

        if (!$validAtasan) {
            throw ValidationException::withMessages([
                'atasan_id' => 'Atasan harus sesuai perusahaan, departemen, dan memiliki posisi lebih tinggi dari talent yang dipilih.',
            ]);
        }

        $selectedMentorIds = collect($request->talents)
            ->pluck('mentors')
            ->flatten()
            ->filter()
            ->unique()
            ->values();

        $talentNames = User::query()
            ->whereIn('id', $selectedTalentIds)
            ->pluck('nama', 'id');

        $mentorNotifications = [];
        $talentNotifications = [];
        $atasanNotifications = [];
        $targetPositionName = Position::find($request->target_position_id)?->position_name ?? 'posisi yang dituju';
        $atasanName = User::find($request->atasan_id)?->nama ?? 'Atasan';
        $mentorNamesById = User::query()
            ->whereIn('id', $selectedMentorIds)
            ->pluck('nama', 'id');
        $periodLabel = $this->formatPlanPeriod($request->start_date, $request->target_date);

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

        foreach ($request->talents as $index => $talentData) {
            $talentGrade = optional(optional($selectedTalentPositions->get($talentData['talent_id']))->position)->grade_level;

            if ($talentGrade === null) {
                continue;
            }

            $mentorIdsForTalent = collect($talentData['mentors'] ?? [])
                ->filter()
                ->unique()
                ->values();

            $higherMentorCount = User::query()
                ->whereIn('id', $mentorIdsForTalent)
                ->whereHas('position', fn($positionQuery) => $positionQuery->where('grade_level', '>', $talentGrade))
                ->count();

            if ($higherMentorCount !== $mentorIdsForTalent->count()) {
                throw ValidationException::withMessages([
                    "talents.$index.mentors" => 'Mentor harus memiliki posisi lebih tinggi dari talent yang dipilih.',
                ]);
            }
        }

        DB::transaction(function () use ($request, $editingTalentIds, $selectedTalentIds, $isEditMode, $talentNames, $targetPositionName, $atasanName, $mentorNamesById, $periodLabel, &$mentorNotifications, &$talentNotifications, &$atasanNotifications) {
            if ($isEditMode) {
                $removedTalentIds = $editingTalentIds
                    ->diff($selectedTalentIds->map(fn($id) => (string) $id));

                if ($removedTalentIds->isNotEmpty()) {
                    User::whereIn('id', $removedTalentIds->all())->update([
                        'mentor_id' => null,
                        'atasan_id' => null,
                    ]);

                    PromotionPlan::whereIn('user_id_talent', $removedTalentIds->all())
                        ->where('is_active', true)
                        ->update(['is_active' => false]);

                    DevelopmentSession::whereIn('user_id_talent', $removedTalentIds->all())
                        ->where('is_active', true)
                        ->update([
                            'is_active' => false,
                            'status' => 'Removed',
                            'completed_at' => now(),
                        ]);
                }
            }

            foreach ($request->talents as $talentData) {
                $talentId = $talentData['talent_id'];
                $sourcePositionId = User::where('id', $talentId)->value('position_id');
                $existingPlan = PromotionPlan::where('user_id_talent', $talentId)
                    ->where('is_active', true)
                    ->first();

                // If there's an active plan with completed status, archive it (don't delete!)
                if ($existingPlan && in_array($existingPlan->status_promotion, ['Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'])) {
                    $existingPlan->update(['is_active' => false]);
                    $existingPlan = null; // Reset for fresh creation
                }

                $planAlreadyExists = (bool) $existingPlan;
                $developmentSession = $existingPlan?->developmentSession;

                if ($planAlreadyExists && !$developmentSession) {
                    $developmentSession = DevelopmentSession::create([
                        'user_id_talent' => $talentId,
                        'source_position_id' => $sourcePositionId,
                        'target_position_id' => $existingPlan->target_position_id,
                        'atasan_id' => $request->atasan_id,
                        'mentor_ids' => $existingPlan->mentor_ids,
                        'status' => $existingPlan->status_promotion,
                        'start_date' => $existingPlan->start_date,
                        'target_date' => $existingPlan->target_date,
                        'is_active' => true,
                    ]);
                    $existingPlan->update(['development_session_id' => $developmentSession->id]);

                    // Link any floating assessment_session to this new development session
                    DB::table('assessment_session')
                        ->where('user_id_talent', $talentId)
                        ->whereNull('development_session_id')
                        ->update(['development_session_id' => $developmentSession->id]);
                }

                $existingMentorIds = collect($existingPlan?->mentor_ids ?? [])
                    ->map(fn($id) => (string) $id)
                    ->filter()
                    ->values();
                $mentorIds = collect($talentData['mentors'])
                    ->filter()
                    ->values()
                    ->all();
                $newMentorIds = collect($mentorIds)
                    ->map(fn($id) => (string) $id)
                    ->filter()
                    ->values();
                $newlyAssignedMentorIds = $newMentorIds
                    ->diff($existingMentorIds)
                    ->map(fn($id) => (int) $id)
                    ->values()
                    ->all();
                $primaryMentorId = $mentorIds[0] ?? null;

                User::where('id', $talentId)->update([
                    'mentor_id' => $primaryMentorId,
                    'atasan_id' => $request->atasan_id,
                ]);

                // If active plan exists, update it; otherwise create new one
                if ($planAlreadyExists) {
                    $plan = PromotionPlan::where('user_id_talent', $talentId)
                        ->where('is_active', true)
                        ->first();

                    $developmentSession->update([
                        'target_position_id' => $request->target_position_id,
                        'source_position_id' => $developmentSession->source_position_id ?: $sourcePositionId,
                        'atasan_id' => $request->atasan_id,
                        'mentor_ids' => $mentorIds,
                        'status' => 'In Progress',
                        'start_date' => $request->start_date,
                        'target_date' => $request->target_date,
                        'completed_at' => null,
                        'is_active' => true,
                    ]);

                    $plan->update([
                        'development_session_id' => $developmentSession->id,
                        'target_position_id' => $request->target_position_id,
                        'mentor_ids' => $mentorIds,
                        'status_promotion' => 'In Progress',
                        'start_date' => $request->start_date,
                        'target_date' => $request->target_date,
                    ]);
                } else {
                    $developmentSession = DevelopmentSession::create([
                        'user_id_talent' => $talentId,
                        'source_position_id' => $sourcePositionId,
                        'target_position_id' => $request->target_position_id,
                        'atasan_id' => $request->atasan_id,
                        'mentor_ids' => $mentorIds,
                        'status' => 'In Progress',
                        'start_date' => $request->start_date,
                        'target_date' => $request->target_date,
                        'is_active' => true,
                    ]);

                    $plan = PromotionPlan::create([
                        'development_session_id' => $developmentSession->id,
                        'user_id_talent' => $talentId,
                        'target_position_id' => $request->target_position_id,
                        'mentor_ids' => $mentorIds,
                        'status_promotion' => 'In Progress',
                        'start_date' => $request->start_date,
                        'target_date' => $request->target_date,
                        'is_active' => true,
                    ]);

                    // Link any floating assessment_session to this new development session
                    DB::table('assessment_session')
                        ->where('user_id_talent', $talentId)
                        ->whereNull('development_session_id')
                        ->update(['development_session_id' => $developmentSession->id]);
                }

                if ($plan->wasRecentlyCreated && $request->query('plan_created_at')) {
                    $plan->timestamps = false;
                    $plan->created_at = $request->query('plan_created_at');
                    $plan->save();
                    $plan->timestamps = true;
                }

                $mentorList = collect($mentorIds)
                    ->map(fn($mentorId) => $mentorNamesById[$mentorId] ?? null)
                    ->filter()
                    ->join(', ');

                $talentNotifications[] = [
                    'user_id' => $talentId,
                    'title' => $planAlreadyExists ? 'Development Plan Diperbarui' : 'Development Plan Baru',
                    'desc' => 'PDC Admin telah ' . ($planAlreadyExists ? 'memperbarui' : 'membuat') . ' development plan Anda: posisi yang dituju <span class="font-semibold">' . e($targetPositionName) . '</span>, mentor <span class="font-semibold">' . e($mentorList ?: '-') . '</span>, atasan <span class="font-semibold">' . e($atasanName) . '</span>, periode <span class="font-semibold">' . e($periodLabel) . '</span>.',
                    'type' => 'info',
                ];

                $atasanNotifications[] = [
                    'user_id' => (int) $request->atasan_id,
                    'title' => $planAlreadyExists ? 'Development Plan Talent Diperbarui' : 'Talent Baru pada Development Plan',
                    'desc' => 'PDC Admin telah memilih <span class="font-semibold">' . e($talentNames[$talentId] ?? 'Talent') . '</span> ke development plan Anda untuk posisi tujuan <span class="font-semibold">' . e($targetPositionName) . '</span> pada periode <span class="font-semibold">' . e($periodLabel) . '</span>.',
                    'type' => 'info',
                ];

                if (!empty($newlyAssignedMentorIds)) {
                    $talentName = $talentNames[$talentId] ?? 'Talent';

                    foreach ($newlyAssignedMentorIds as $mentorId) {
                        $mentorNotifications[] = [
                            'user_id' => $mentorId,
                            'title' => 'Talent Baru pada Development Plan',
                            'desc' => 'PDC Admin telah memilih <span class="font-semibold">' . e($talentName) . '</span> sebagai talent untuk Anda pada development plan.',
                            'type' => 'info',
                        ];
                    }
                }
            }
        });

        foreach ($mentorNotifications as $notification) {
            $this->addNotificationToUser(
                $notification['user_id'],
                $notification['title'],
                $notification['desc'],
                $notification['type']
            );
        }

        foreach ($talentNotifications as $notification) {
            $this->addNotificationToUser(
                $notification['user_id'],
                $notification['title'],
                $notification['desc'],
                $notification['type']
            );
        }

        foreach (collect($atasanNotifications)->unique(fn($notification) => implode('|', [$notification['user_id'], $notification['title'], strip_tags($notification['desc'])])) as $notification) {
            $this->addNotificationToUser(
                $notification['user_id'],
                $notification['title'],
                $notification['desc'],
                $notification['type']
            );
        }
    }

    protected function getGroupedTalentsForPlan(int $companyId, int $positionId, ?int $departmentId = null, ?string $planCreatedAt = null)
    {
        return User::where('company_id', $companyId)
            ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
            ->whereHas('promotion_plan', function ($q) use ($positionId, $planCreatedAt) {
                $q->where('target_position_id', $positionId);
                if ($planCreatedAt) {
                    $q->where('created_at', $planCreatedAt);
                }
            })
            ->with(['promotion_plan', 'department'])
            ->orderBy('nama')
            ->get();
    }

    public function detail(Request $request, $company_id, $position_id)
    {
        $user = auth()->user();
        $company = Company::findOrFail($company_id);
        $targetPosition = Position::findOrFail($position_id);
        $departmentId = $request->query('department_id');
        $planCreatedAt = $request->query('plan_created_at');

        $talents = User::where('company_id', $company_id)
            ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
            ->whereHas('promotion_plan', function ($q) use ($position_id, $planCreatedAt) {
                $q->where('target_position_id', $position_id);
                if ($planCreatedAt) {
                    $q->where('created_at', $planCreatedAt);
                }
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

    public function detailTalent(int $talent_id)
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

        $this->authorize('view-talent-data', $talent);

        // Build a single-item collection so the existing detail.blade.php loop still works
        $talents = collect([$talent]);

        $company = $talent->company;
        $targetPosition = optional($talent->promotion_plan)->targetPosition;

        $competencies = Competence::all();

        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ? PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
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

        [$exposureData, $mentoringData, $learningData] = $this->formatLogbookActivities($activities);

        return view('pdc_admin.logbook', compact(
            'user',
            'talent',
            'exposureData',
            'mentoringData',
            'learningData'
        ));
    }

    public function progressArchiveLogbook(Request $request, $talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'all_promotion_plans.targetPosition',
            'all_promotion_plans.developmentSession.sourcePosition',
        ])->findOrFail($talent_id);

        $requestedSessionId = $request->query('session_id');
        $archivedPlan = $requestedSessionId
            ? $talent->all_promotion_plans->firstWhere('development_session_id', (int) $requestedSessionId)
            : $talent->all_promotion_plans->first(fn($plan) => !$plan->is_active);
        $sessionId = $archivedPlan?->development_session_id;

        $talent->promotion_plan = $archivedPlan ?? $talent->all_promotion_plans->first();
        if ($archivedPlan?->developmentSession?->sourcePosition) {
            $talent->setRelation('position', $archivedPlan->developmentSession->sourcePosition);
        }

        $activities = \App\Models\IDPActivity::with(['type', 'verifier'])
            ->where('user_id_talent', $talent->id)
            ->when($sessionId, fn($query) => $query->where('development_session_id', $sessionId))
            ->orderBy('created_at', 'desc')
            ->get();

        [$exposureData, $mentoringData, $learningData] = $this->formatLogbookActivities($activities);

        $pageTitle = 'LogBook Archive';
        $pageSubtitle = 'Rekam jejak aktivitas pengembangan archive talent ' . $talent->nama;

        return view('pdc_admin.logbook', compact(
            'user',
            'talent',
            'exposureData',
            'mentoringData',
            'learningData',
            'pageTitle',
            'pageSubtitle'
        ));
    }

    protected function formatLogbookActivities($activities): array
    {
        $exposureData = [];
        $mentoringData = [];
        $learningData = [];

        foreach ($activities as $act) {
            $typeName = strtolower($act->type?->type_name ?? '');

            if (str_contains($typeName, 'exposure')) {
                $exposureData[] = [
                    'id' => $act->id,
                    'mentor' => $act->verifier?->nama ?? '-',
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'status' => $act->status,
                ];
            } elseif (str_contains($typeName, 'mentor')) {
                $mentoringData[] = [
                    'id' => $act->id,
                    'mentor' => $act->verifier?->nama ?? '-',
                    'tema' => $act->theme,
                    'tanggal_update' => $act->updated_at,
                    'tanggal' => $act->activity_date,
                    'status' => $act->status,
                ];
            } elseif (str_contains($typeName, 'learn')) {
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

        return [$exposureData, $mentoringData, $learningData];
    }

    public function financeValidation()
    {
        $user = auth()->user();

        $projects = ImprovementProject::where('is_active', true)->with([
            'talent.position',
            'talent.department',
            'talent.promotion_plan.targetPosition',
        ])
            ->whereHas('talent.promotion_plan', function ($q) {
                $q->whereNotIn('status_promotion', ['Promoted', 'Not Promoted']);
            })
            ->orderByRaw("FIELD(status, 'Pending', 'Approved', 'Rejected')")
            ->orderBy('created_at', 'desc')
            ->get();

        $total = $projects->count();
        $pending = $projects->filter(function ($project) {
            return empty($project->finance_feedback) ||
                (!str_starts_with($project->finance_feedback, '[Approved]') &&
                    !str_starts_with($project->finance_feedback, '[Rejected]'));
        })->count();
        $approved = $projects->filter(function ($project) {
            return !empty($project->finance_feedback) && str_starts_with($project->finance_feedback, '[Approved]');
        })->count();
        $rejected = $projects->filter(function ($project) {
            return !empty($project->finance_feedback) && str_starts_with($project->finance_feedback, '[Rejected]');
        })->count();

        $financeUsers = \App\Models\User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))->get();

        return view('pdc_admin.finance-validation', compact('user', 'projects', 'total', 'pending', 'approved', 'rejected', 'financeUsers'));
    }

    public function updateFinanceValidation(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Verified,Approved,Rejected']);

        $project = ImprovementProject::findOrFail($id);

        $decision = $request->status === 'Verified' ? 'Approved' : $request->status;
        $dbStatus = $decision === 'Approved' ? 'Verified' : 'Rejected';

        $updateData = [
            'status' => $dbStatus,
            'verify_by' => auth()->id(),
            'verify_at' => now(),
        ];

        // Jika diproses langsung oleh Admin PDC tanpa via Finance, set finance_feedback
        if (empty($project->finance_feedback)) {
            $updateData['finance_feedback'] = "[$decision] Diproses langsung oleh PDC Admin tanpa review Finance.";
        }

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
            'Keputusan Project Improvement dari PDC Admin',
            'PDC Admin telah menindaklanjuti hasil finance validation dan memperbarui Project Improvement Anda menjadi <span class="font-semibold">' . $dbStatus . '</span>.' . $feedbackNote,
            $dbStatus === 'Approved' ? 'success' : 'warning'
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
        $request->validate([
            'competence_id' => 'required|exists:competence,id',
            'questions' => 'required|array',
            'questions.*.level' => 'required|integer|min:1|max:5',
            'questions.*.text' => 'nullable|string|max:1000',
            'questions.*.id' => 'nullable|exists:question,id',
        ]);

        foreach ($request->questions as $levelData) {
            if ($levelData['id'] ?? null) {
                // Scope ke competence yang benar
                Question::where('id', $levelData['id'])
                    ->where('competence_id', $request->competence_id)
                    ->update(['question_text' => strip_tags($levelData['text'] ?? '')]);
            } elseif ($levelData['text'] ?? '') {
                Question::create([
                    'competence_id' => $request->competence_id,
                    'level' => $levelData['level'],
                    'question_text' => strip_tags($levelData['text']),
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
            $q->whereRaw('LOWER(TRIM(role_name)) = ?', ['talent']);
        })->with(['position', 'department', 'company', 'roles'])->latest()->get();

        $mentors = User::whereHas('roles', function ($q) {
            $q->whereRaw('LOWER(TRIM(role_name)) = ?', ['mentor']);
        })->with(['position', 'department', 'company', 'roles'])->latest()->get();

        $finances = User::whereHas('roles', function ($q) {
            $q->whereRaw('LOWER(TRIM(role_name)) = ?', ['finance']);
        })->with(['position', 'department', 'company', 'roles'])->latest()->get();

        $panelisUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('role_name', ['bo_director', 'panelis', 'board_of_directors', 'board_of_director', 'panelis']);
        })->with(['position', 'department', 'company', 'roles'])->latest()->get();

        $atasans = User::whereHas('roles', function ($q) {
            $q->whereRaw('LOWER(TRIM(role_name)) = ?', ['atasan']);
        })->with(['position', 'department', 'company', 'roles'])->latest()->get();

        $counts = [
            'Talent'  => $talents->count(),
            'Mentor'  => $mentors->count(),
            'Atasan'  => $atasans->count(),
            'Finance' => $finances->count(),
            'Panelis' => $panelisUsers->count(),
        ];

        $departments = Department::orderBy('nama_department')->get();
        $departmentsByCompany = $departments
            ->groupBy('company_id')
            ->map(fn($items) => $items->map(fn($dept) => [
                'id' => $dept->id,
                'nama_department' => $dept->nama_department,
                'company_id' => $dept->company_id,
            ])->values())
            ->toArray();
        $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->get();
        $rolesData = Role::all(); // Provide all roles for the assign modal
        $companies = Company::orderByRaw("
            CASE 
                WHEN nama_company LIKE '%Inti corpora%' THEN 1
                WHEN nama_company LIKE '%Pustaka mandiri%' THEN 2
                WHEN nama_company LIKE '%Wangsa Jatra Lestari%' THEN 3
                WHEN nama_company LIKE '%Assalam Niaga Utama%' THEN 4
                WHEN nama_company LIKE '%K33 Distribusi%' THEN 5
                ELSE 6 
            END ASC
        ")->orderBy('nama_company')->get();

        return view('pdc_admin.user-management', compact('user', 'talents', 'mentors', 'finances', 'panelisUsers', 'atasans', 'departments', 'departmentsByCompany', 'positions', 'rolesData', 'companies', 'counts'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'nama' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'exists:role,id'],
            'company_id' => ['required', 'exists:company,id'],
            'department_id' => ['nullable', 'exists:department,id'],
            'position_id' => ['nullable', 'exists:position,id'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username tersebut sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email tersebut sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf kapital, huruf kecil, dan angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'role_id.required' => 'Role wajib dipilih.',
            'company_id.required' => 'Perusahaan wajib dipilih.',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'company_id' => $request->company_id,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'role_id' => $request->role_id,
            ]);

            DB::table('user_role')->insert([
                'id_user' => $user->id,
                'id_role' => $request->role_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('pdc_admin.user_management')
                ->with('success', 'User "' . $user->nama . '" berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['email' => 'Gagal menambahkan user: ' . $e->getMessage()]);
        }
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
            $sessions = \App\Models\AssessmentSession::withTrashed()
                ->where('user_id_talent', $id)
                ->get();

            foreach ($sessions as $session) {
                \App\Models\DetailAssessment::withTrashed()
                    ->where('assessment_id', $session->id)
                    ->delete();
                $session->delete();
            }

            // Hapus data yang dependen langsung karena dia sebagai Talent
            \App\Models\ImprovementProject::where('user_id_talent', $id)->delete();
            \App\Models\IdpActivity::where('user_id_talent', $id)->delete();
            \App\Models\PanelisAssessment::where('user_id_talent', $id)->delete();
            \App\Models\PromotionPlan::where('user_id_talent', $id)->delete();

            // Jika user adalah Panelis
            \App\Models\PanelisAssessment::where('panelis_id', $id)->delete();

            // Keep role pivot records so data can be restored later if needed
            // $targetUser->roles()->detach();

            // Preserve password reset tokens instead of hard deleting them
            // \Illuminate\Support\Facades\DB::table('password_resets')->where('user_id', $id)->delete();

            // Selesaikan soft delete user
            $targetUser->delete();
        });

        return back()->with('success', 'User berhasil dihapus (soft delete) beserta data terkait.');
    }

    public function requestFinanceValidation(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'notes' => 'required|string',
            'assigned_finance_id' => 'required|exists:users,id',
        ]);

        $project = ImprovementProject::with('talent')->find($request->project_id);
        if ($project) {
            $assignedFinance = User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))
                ->find($request->assigned_finance_id);

            if (
                !$assignedFinance ||
                !$project->talent ||
                (string) $assignedFinance->company_id !== (string) $project->talent->company_id
            ) {
                throw ValidationException::withMessages([
                    'assigned_finance_id' => 'Finance yang dipilih harus sesuai dengan perusahaan talent.',
                ]);
            }

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
        } catch (\Exception $e) {
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
            ->whereHas('improvementProjects')
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
        $totalProjectImprovement = ImprovementProject::distinct('user_id_talent')->count('user_id_talent');

        $belumDinilai = 0;
        $sudahDinilai = 0;

        foreach ($talents as $talent) {
            $alreadySent = in_array(
                optional($talent->promotion_plan)->status_promotion,
                ['Pending Panelis', 'Approved Panelis', 'Rejected Panelis']
            );
            $sessionId = optional($talent->promotion_plan)->development_session_id;
            $isReviewedByPanelis = \App\Models\PanelisAssessment::where('user_id_talent', $talent->id)
                ->when($sessionId, fn($q) => $q->where('development_session_id', $sessionId))
                ->whereNotNull('panelis_score')
                ->exists();

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

        $activePlan = PromotionPlan::where('user_id_talent', $talent_id)
            ->where('is_active', true)
            ->latest('created_at')
            ->first();
        $sessionId = $activePlan?->development_session_id;

        $progressTalents = $activePlan
            ? $this->getPanelisProgressTalents($activePlan, $talent)
            : collect([$talent]);

        $talentReviews = $progressTalents->map(function ($progressTalent) {
            $plan = $progressTalent->promotion_plan;
            $progressSessionId = optional($plan)->development_session_id;

            $assignedPanelisIds = \App\Models\PanelisAssessment::where('user_id_talent', $progressTalent->id)
                ->when($progressSessionId, fn($q) => $q->where('development_session_id', $progressSessionId))
                ->pluck('panelis_id');

            $panelisUsers = User::whereIn('id', $assignedPanelisIds)
                ->with(['company', 'position'])
                ->orderBy('nama')
                ->get();

            $panelisAssessmentsByPanelis = \App\Models\PanelisAssessment::where('user_id_talent', $progressTalent->id)
                ->when($progressSessionId, fn($q) => $q->where('development_session_id', $progressSessionId))
                ->whereIn('panelis_id', $assignedPanelisIds)
                ->get()
                ->keyBy('panelis_id');

            $latestProject = $progressSessionId
                ? $progressTalent->improvementProjects->where('development_session_id', $progressSessionId)->sortByDesc('updated_at')->first()
                : $progressTalent->improvementProjects->sortByDesc('updated_at')->first();

            return [
                'talent' => $progressTalent,
                'panelisUsers' => $panelisUsers,
                'panelisAssessmentsByPanelis' => $panelisAssessmentsByPanelis,
                'latestProject' => $latestProject,
            ];
        });

        return view('pdc_admin.panelis-review-detail', compact(
            'user',
            'talent',
            'talentReviews'
        ));
    }

    public function panelisReviewComplete(Request $request, $talent_id)
    {
        $request->validate([
            'decision' => 'required|in:ready_now,ready_1_2_years,ready_over_2_years,not_ready',
        ]);

        $plan = PromotionPlan::where('user_id_talent', $talent_id)
            ->where('is_active', true)
            ->latest('created_at')
            ->firstOrFail();
        $talent = User::findOrFail($talent_id);
        $targetPosition = optional($plan->targetPosition)->position_name ?? 'posisi yang dituju';

        if ($request->decision === 'ready_now') {
            // ── READY NOW: keputusan akhir tanpa mengubah posisi talent ──
            $plan->update(['status_promotion' => 'Promoted']);

            $this->addNotificationToUser(
                $talent_id,
                'Hasil Evaluasi Development Talent',
                'PDC Admin telah menyelesaikan evaluasi Anda. Keputusan: <span class="font-semibold text-green-600">Ready Now</span> untuk posisi <span class="font-semibold">' . $targetPosition . '</span>. Perubahan posisi akan dilakukan secara manual melalui User Management.',
                'success'
            );

            $message = 'Keputusan "Ready Now" untuk ' . $talent->nama . ' telah disimpan. Posisi talent tidak diubah otomatis.';

            $this->archiveDevelopmentSession($talent, $plan, 'Promoted');
        } elseif ($request->decision === 'ready_1_2_years') {
            // ── READY IN 1-2 YEARS: Belum diangkat, posisi tetap ──
            $plan->update(['status_promotion' => 'Ready in 1-2 Years']);

            $this->addNotificationToUser(
                $talent_id,
                '📋 Hasil Evaluasi Development Talent',
                'PDC Admin telah menyelesaikan evaluasi Anda. Keputusan: <span class="font-semibold text-blue-600">Ready in 1–2 Years</span>. Anda direkomendasikan ke posisi <span class="font-semibold">' . $targetPosition . '</span> dalam 1–2 tahun ke depan. Terus kembangkan diri Anda!',
                'info'
            );

            $message = 'Keputusan "Ready in 1–2 Years" untuk ' . $talent->nama . ' telah disimpan.';

            $this->archiveDevelopmentSession($talent, $plan, 'Ready in 1-2 Years');
        } elseif ($request->decision === 'ready_over_2_years') {
            // ── READY IN > 2 YEARS: Belum diangkat, posisi tetap ──
            $plan->update(['status_promotion' => 'Ready in > 2 Years']);

            $this->addNotificationToUser(
                $talent_id,
                '📋 Hasil Evaluasi Development Talent',
                'PDC Admin telah menyelesaikan evaluasi Anda. Keputusan: <span class="font-semibold text-amber-600">Ready in &gt; 2 Years</span>. Anda masih membutuhkan pengembangan lebih lanjut sebelum siap untuk posisi <span class="font-semibold">' . $targetPosition . '</span>. Terus tingkatkan kompetensi Anda!',
                'warning'
            );

            $message = 'Keputusan "Ready in > 2 Years" untuk ' . $talent->nama . ' telah disimpan.';

            $this->archiveDevelopmentSession($talent, $plan, 'Ready in > 2 Years');
        } else {
            // ── NOT READY: Belum siap, posisi tetap ──
            $plan->update(['status_promotion' => 'Not Ready']);

            $this->addNotificationToUser(
                $talent_id,
                '📋 Hasil Evaluasi Development Talent',
                'PDC Admin telah menyelesaikan proses evaluasi Anda. Berdasarkan hasil penilaian, Anda dinyatakan <span class="font-semibold text-red-600">Not Ready</span> untuk posisi <span class="font-semibold">' . $targetPosition . '</span> pada periode ini. Terus tingkatkan kompetensi Anda!',
                'warning'
            );

            $message = 'Keputusan "Not Ready" untuk ' . $talent->nama . ' telah disimpan.';

            $this->archiveDevelopmentSession($talent, $plan, 'Not Ready');
        }

        return redirect()->route('pdc_admin.progress_archive')->with('success', $message);
    }

    public function sendPanelisReview(Request $request, $talent_id)
    {
        $plan = PromotionPlan::where('user_id_talent', $talent_id)
            ->where('is_active', true)
            ->latest('created_at')
            ->firstOrFail();
        $talent = User::with(['company', 'department'])->findOrFail($talent_id);
        $progressTalents = $this->getPanelisProgressTalents($plan, $talent);

        if (!$plan->is_locked) {
            return back()->with('error', 'Progress harus dikunci terlebih dahulu sebelum dikirim ke Panelis.');
        }

        if ($progressTalents->contains(fn($progressTalent) => !optional($progressTalent->promotion_plan)->is_locked)) {
            return back()->with('error', 'Semua talent dalam progress ini harus terkunci sebelum dikirim ke Panelis.');
        }

        $request->validate([
            'panelis_ids' => 'required|array|min:1',
            'panelis_ids.*' => 'exists:users,id'
        ]);

        foreach ($progressTalents as $progressTalent) {
            $progressPlan = $progressTalent->promotion_plan;

            // Deactivate panelist assessments that are no longer selected
            \App\Models\PanelisAssessment::where('user_id_talent', $progressTalent->id)
                ->where('development_session_id', optional($progressPlan)->development_session_id)
                ->whereNotIn('panelis_id', $request->panelis_ids)
                ->update(['is_active' => false]);

            foreach ($request->panelis_ids as $panelis_id) {
                \App\Models\PanelisAssessment::updateOrCreate([
                    'user_id_talent' => $progressTalent->id,
                    'development_session_id' => optional($progressPlan)->development_session_id,
                    'panelis_id' => $panelis_id,
                ], [
                    'is_active' => true,
                ]);
            }

            optional($progressPlan)->update(['status_promotion' => 'Pending Panelis']);
            if (optional($progressPlan)->development_session_id) {
                DevelopmentSession::where('id', $progressPlan->development_session_id)->update(['status' => 'Pending Panelis']);
            }
        }

        $talentNames = $progressTalents->pluck('nama')->join(', ');
        foreach ($request->panelis_ids as $panelis_id) {
            $this->addNotificationToUser(
                $panelis_id,
                'Permintaan Penilaian Baru dari PDC Admin',
                'PDC Admin telah mengirimkan talent <span class="font-semibold">' . e($talentNames) . '</span> untuk Anda berikan penilaian panelis.',
                'info'
            );
        }

        return back()->with('success', 'Berhasil mengirim progress ini ke Panelis untuk review.');
    }

    public function toggleLock($talent_id)
    {
        $plan = PromotionPlan::where('user_id_talent', $talent_id)
            ->where('is_active', true)
            ->latest('created_at')
            ->firstOrFail();
        $talent = User::with(['company', 'department'])->findOrFail($talent_id);
        $progressTalents = $this->getPanelisProgressTalents($plan, $talent);
        $shouldLock = !$progressTalents->every(fn($progressTalent) => optional($progressTalent->promotion_plan)->is_locked);

        PromotionPlan::whereIn('user_id_talent', $progressTalents->pluck('id'))
            ->where('is_active', true)
            ->update(['is_locked' => $shouldLock]);

        $status = $shouldLock ? 'dikunci' : 'dibuka';
        return back()->with('success', "Progress talent berhasil $status untuk " . $progressTalents->count() . " talent.");
    }

    private function getPanelisProgressTalents(PromotionPlan $plan, User $anchorTalent)
    {
        return User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))
            ->where('company_id', $anchorTalent->company_id)
            ->where('department_id', $anchorTalent->department_id)
            ->where('atasan_id', $anchorTalent->atasan_id)
            ->whereHas('promotion_plan', function ($query) use ($plan) {
                $query->where('is_active', true)
                    ->where('target_position_id', $plan->target_position_id)
                    ->whereDate('start_date', $plan->start_date)
                    ->whereDate('target_date', $plan->target_date);
            })
            ->with([
                'company',
                'department',
                'position',
                'mentor',
                'atasan',
                'promotion_plan.targetPosition',
                'improvementProjects',
            ])
            ->orderBy('nama')
            ->get()
            ->each(function ($progressTalent) {
                $sessionId = optional($progressTalent->promotion_plan)->development_session_id;
                if ($sessionId) {
                    $progressTalent->improvementProjects = $progressTalent->improvementProjects
                        ->where('development_session_id', $sessionId)
                        ->values();
                }
            });
    }

    protected function archiveDevelopmentSession(User $talent, PromotionPlan $plan, string $finalStatus): void
    {
        $sessionId = $plan->development_session_id;

        if ($sessionId) {
            DevelopmentSession::where('id', $sessionId)->update([
                'status' => $finalStatus,
                'is_active' => false,
                'completed_at' => now(),
            ]);

            PromotionPlan::where('development_session_id', $sessionId)->update(['is_active' => false]);
            \App\Models\AssessmentSession::where('development_session_id', $sessionId)->update(['is_active' => false]);
            \App\Models\IdpActivity::where('development_session_id', $sessionId)->update(['is_active' => false]);
            \App\Models\ImprovementProject::where('development_session_id', $sessionId)->update(['is_active' => false]);
            \App\Models\PanelisAssessment::where('development_session_id', $sessionId)->update(['is_active' => false]);

            return;
        }

        $talent->promotion_plan()->update(['is_active' => false]);
        $talent->assessmentSession()->update(['is_active' => false]);
        $talent->idpActivities()->update(['is_active' => false]);
        $talent->improvementProjects()->update(['is_active' => false]);
        $talent->panelisAssessments()->update(['is_active' => false]);
    }

    public function export()
    {
        $user = auth()->user();

        $companies = Company::orderByRaw("
            CASE 
                WHEN nama_company LIKE '%Inti corpora%' THEN 1
                WHEN nama_company LIKE '%Pustaka mandiri%' THEN 2
                WHEN nama_company LIKE '%Wangsa Jatra Lestari%' THEN 3
                WHEN nama_company LIKE '%Assalam Niaga Utama%' THEN 4
                WHEN nama_company LIKE '%K33 Distribusi%' THEN 5
                ELSE 6 
            END ASC
        ")->orderBy('nama_company')->get();


        // Fetch talents whose promotion process is completed (all final decision statuses)
        $finalStatuses = ['Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'];
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'Talent');
        })
            ->whereHas('all_promotion_plans', function ($q) use ($finalStatuses) {
                $q->where('is_active', false)->whereIn('status_promotion', $finalStatuses);
            })
            ->with([
                'company',
                'department',
                'position',
                'all_promotion_plans' => function ($q) use ($finalStatuses) {
                    $q->where('is_active', false)->whereIn('status_promotion', $finalStatuses);
                },
                'all_promotion_plans.developmentSession.sourcePosition',
                'all_improvementProjects'
            ])
            ->get();

        // Initialize groupedData with ALL companies
        $groupedData = collect();
        foreach ($companies as $comp) {
            $groupedData[$comp->id] = [
                'company' => $comp,
                'talents' => collect(),
            ];
        }

        // Populate one row per completed development session, not one row per user.
        foreach ($talents as $talent) {
            $company_id = $talent->company_id;
            if (!$company_id || !$groupedData->has($company_id)) {
                continue;
            }

            foreach ($talent->all_promotion_plans as $plan) {
                $archiveRow = $talent->replicate();
                $archiveRow->id = $talent->id;
                $archiveRow->exists = true;
                $archiveRow->setRelations($talent->getRelations());
                $archiveRow->promotion_plan = $plan;
                $archiveRow->archive_session_id = $plan->development_session_id;
                $archiveRow->archive_source_position_name = optional(optional($plan->developmentSession)->sourcePosition)->position_name
                    ?? optional($talent->position)->position_name;
                $archiveRow->improvementProjects = $plan->development_session_id
                    ? $talent->all_improvementProjects->where('development_session_id', $plan->development_session_id)->values()
                    : $talent->all_improvementProjects;

                $groupedData[$company_id]['talents']->push($archiveRow);
            }
        }

        // Attach panelis review status manually to avoid huge queries
        $sessionIds = collect($groupedData)
            ->flatMap(fn($group) => $group['talents']->pluck('archive_session_id'))
            ->filter()
            ->unique()
            ->values();
        $panelisAssessedSessionIds = \App\Models\PanelisAssessment::whereIn('development_session_id', $sessionIds)
            ->whereNotNull('panelis_score')
            ->pluck('development_session_id')
            ->all();

        foreach ($groupedData as $group) {
            foreach ($group['talents'] as $talent) {
                $talent->is_reviewed_by_panelis = in_array($talent->archive_session_id, $panelisAssessedSessionIds);
            }
        }

        return view('pdc_admin.progress-archive', compact('user', 'groupedData', 'companies'));
    }

    public function exportDetail(Request $request, $talent_id)
    {
        $user = auth()->user();
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'all_promotion_plans.targetPosition',
            'all_promotion_plans.developmentSession.sourcePosition',
            'all_assessmentSessions.details.competence',
            'all_idpActivities.type',
            'all_improvementProjects.verifier',
            'all_panelisAssessments.panelis.company',
            'all_panelisAssessments.panelis.position'
        ])->findOrFail($talent_id);

        // Map one archived development session to the legacy view properties.
        $requestedSessionId = $request->query('session_id');
        $archivedPlan = $requestedSessionId
            ? $talent->all_promotion_plans->firstWhere('development_session_id', (int) $requestedSessionId)
            : $talent->all_promotion_plans->first(fn($plan) => !$plan->is_active);
        $sessionId = $archivedPlan?->development_session_id;
        $talent->promotion_plan = $archivedPlan ?? $talent->all_promotion_plans->first();
        if ($archivedPlan?->developmentSession?->sourcePosition) {
            $talent->setRelation('position', $archivedPlan->developmentSession->sourcePosition);
        }
        $talent->assessmentSession = $sessionId
            ? $talent->all_assessmentSessions->firstWhere('development_session_id', $sessionId)
            : $talent->all_assessmentSessions->first();
        $talent->idpActivities = $sessionId
            ? $talent->all_idpActivities->where('development_session_id', $sessionId)->values()
            : $talent->all_idpActivities;
        $talent->improvementProjects = $sessionId
            ? $talent->all_improvementProjects->where('development_session_id', $sessionId)->values()
            : $talent->all_improvementProjects;
        $talent->panelisAssessments = $sessionId
            ? $talent->all_panelisAssessments->where('development_session_id', $sessionId)->values()
            : $talent->all_panelisAssessments;

        $competencies = Competence::all();

        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ? PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        // Build top 3 GAP list
        $sess = $talent->assessmentSession;
        $gaps = collect();
        if ($sess && $sess->details->count()) {
            $overrides = $sess->details->filter(fn($d) => str_starts_with($d->notes ?? '', 'priority_'))
                ->sortBy(fn($d) => (int) explode('|', str_replace('priority_', '', $d->notes))[0]);
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

        return view('pdc_admin.progress-archive_detail', compact(
            'user',
            'talent',
            'competencies',
            'standards',
            'gaps',
            'exposureCount',
            'mentoringCount',
            'learningCount',
            'sessionId'
        ));
    }


    public function exportPdf(Request $request, int $talent_id)
    {
        $talent = User::with([
            'company',
            'department',
            'position',
            'mentor',
            'atasan',
            'all_promotion_plans.targetPosition',
            'all_promotion_plans.developmentSession.sourcePosition',
            'all_assessmentSessions.details.competence',
            'all_idpActivities.type',
            'all_improvementProjects.verifier',
            'all_panelisAssessments.panelis.company',
            'all_panelisAssessments.panelis.position'
        ])->findOrFail($talent_id);

        $requestedSessionId = $request->query('session_id');
        $archivedPlan = $requestedSessionId
            ? $talent->all_promotion_plans->firstWhere('development_session_id', (int) $requestedSessionId)
            : $talent->all_promotion_plans->first(fn($plan) => !$plan->is_active);
        $sessionId = $archivedPlan?->development_session_id;
        $talent->promotion_plan = $archivedPlan ?? $talent->all_promotion_plans->first();
        if ($archivedPlan?->developmentSession?->sourcePosition) {
            $talent->setRelation('position', $archivedPlan->developmentSession->sourcePosition);
        }
        $talent->assessmentSession = $sessionId
            ? $talent->all_assessmentSessions->firstWhere('development_session_id', $sessionId)
            : $talent->all_assessmentSessions->first();
        $talent->idpActivities = $sessionId
            ? $talent->all_idpActivities->where('development_session_id', $sessionId)->values()
            : $talent->all_idpActivities;
        $talent->improvementProjects = $sessionId
            ? $talent->all_improvementProjects->where('development_session_id', $sessionId)->values()
            : $talent->all_improvementProjects;
        $talent->panelisAssessments = $sessionId
            ? $talent->all_panelisAssessments->where('development_session_id', $sessionId)->values()
            : $talent->all_panelisAssessments;

        $competencies = Competence::all();
        $positionId = optional($talent->promotion_plan)->target_position_id;
        $standards = $positionId
            ? PositionTargetCompetence::where('position_id', $positionId)->pluck('target_level', 'competence_id')
            : collect();

        $bgPath = public_path('asset/Sampul IDP 2 convert.png');
        $logoPath = public_path('asset/LOGO TS dan PDC Transparan.png');
        $borderPath = public_path('asset/Border Raport.png');

        $bg_image = 'data:image/png;base64,' . base64_encode(file_get_contents($bgPath));
        $logo_image = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        $border_image = 'data:image/png;base64,' . base64_encode(file_get_contents($borderPath));

        $pdf = Pdf::loadView('pdc_admin.pdf_export', compact('talent', 'competencies', 'standards', 'bg_image', 'logo_image', 'border_image'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);

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

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'company_id' => 'required|exists:company,id',
            'department_id' => 'nullable|exists:department,id',
            'position_id' => 'nullable|exists:position,id',
        ]);

        $originalData = $user->getOriginal();

        // Selalu update field dasar
        $updateData = [
            'username' => $request->username,
            'nama' => $request->nama,
            'email' => $request->email,
            'company_id' => $request->company_id,
        ];

        // Hanya update departemen & posisi jika dikirim (Talent/Mentor/Atasan)
        // Finance & Panelis tidak memiliki field ini di modal edit
        if ($request->filled('department_id')) {
            $updateData['department_id'] = $request->department_id;
        }
        if ($request->filled('position_id')) {
            $updateData['position_id'] = $request->position_id;
        }

        $user->update($updateData);

        $changes = [];
        if ($originalData['username'] !== $request->username)
            $changes[] = 'Username';
        if ($originalData['nama'] !== $request->nama)
            $changes[] = 'Nama Lengkap';
        if ($originalData['email'] !== $request->email)
            $changes[] = 'Email';
        if ($originalData['company_id'] != $request->company_id)
            $changes[] = 'Perusahaan';
        if (isset($updateData['department_id']) && $originalData['department_id'] != $updateData['department_id'])
            $changes[] = 'Departemen';
        if (isset($updateData['position_id']) && $originalData['position_id'] != $updateData['position_id'])
            $changes[] = 'Posisi';

        if (!empty($changes)) {
            $changedFieldsStr = implode(', ', $changes);
            $this->addNotificationToUser(
                $user->id,
                'Profil Diperbarui oleh Admin',
                'PDC Admin telah memperbarui data profil Anda pada bagian: <span class="font-semibold">' . e($changedFieldsStr) . '</span>.',
                'info'
            );
        }

        return back()->with('success', 'Profil user berhasil diperbarui.');
    }

    public function resetPassword($id)
    {
        $defaultPassword = 'Password123';

        DB::table('users')->where('id', $id)->update([
            'password' => \Illuminate\Support\Facades\Hash::make($defaultPassword),
            'updated_at' => now(),
        ]);

        $this->addNotificationToUser(
            $id,
            'Password Direset',
            'Password Anda telah direset ke default (Password123) oleh admin. Silakan segera mengubah password Anda demi keamanan.',
            'warning'
        );

        return back()->with('success', 'Password user berhasil direset ke default (Password123).');
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
