<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\Competence;
use App\Models\PositionTargetCompetence;
use App\Models\PromotionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PDCAdminController extends Controller
{
    public function notifikasi()
    {
        $notifications = collect([
            ['id' => 1, 'is_read' => false, 'title' => 'Validasi', 'desc' => 'Terdapat validasi finance yang menunggu.', 'time' => '10 menit yang lalu', 'type' => 'warning', 'badge' => 'Perhatian'],
        ]);

        return view('pdc_admin.notifikasi', [
            'user' => auth()->user(),
            'notifications' => $notifications
        ]);
    }

    public function markAllNotificationsRead()
    {
        return back();
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Summary Cards
        $totalUsers = User::count();
        $onProgressTalent = PromotionPlan::where('status_promotion', 'In Progress')->count();
        $pendingFinance = \App\Models\ImprovementProject::whereIn('status', ['Pending', 'On Progress'])->count();
        $pendingBOD = PromotionPlan::where('status_promotion', 'Pending BOD')->count();

        // Role statistics
        $roleCounts = [
            'Talent' => User::whereHas('roles', fn($q) => $q->where('role_name', 'talent'))->count(),
            'Mentor' => User::whereHas('roles', fn($q) => $q->where('role_name', 'mentor'))->count(),
            'Atasan' => User::whereHas('roles', fn($q) => $q->where('role_name', 'atasan'))->count(),
            'Finance' => User::whereHas('roles', fn($q) => $q->where('role_name', 'finance'))->count(),
            'BOD' => User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bo_director', 'bod', 'board_of_directors']))->count(),
        ];

        // Fetch the 3 most recent 'In Progress' talents with their relationships
        $talents = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })
            ->whereHas('promotion_plan', function ($q) {
                $q->where('status_promotion', 'In Progress');
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
        $positions = Position::whereNotIn('position_name', ['Super Admin'])->orderBy('grade_level')->get();
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
                    'start_date' => now(),
                    'target_date' => now()->addYear(),
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
        $departments = \App\Models\Department::orderBy('nama_department')->get();
        $positions = Position::whereNotIn('position_name', ['Super Admin'])->orderBy('grade_level')->get();
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

        $financeUsers = User::whereHas('role', fn($q) => $q->where('role_name', 'finance'))
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

        $financeUsers = User::whereHas('role', fn($q) => $q->where('role_name', 'finance'))
            ->where('company_id', $talent->company_id)
            ->get();

        return view('pdc_admin.detail', compact('user', 'company', 'targetPosition', 'talents', 'competencies', 'standards', 'financeUsers'));
    }

    public function financeValidation()
    {
        $user = auth()->user();

        $projects = \App\Models\ImprovementProject::with('talent')
            ->whereNotNull('feedback')
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

        \App\Models\ImprovementProject::findOrFail($id)->update([
            'status' => $request->status,
            'verify_by' => auth()->id(),
            'verify_at' => now(),
        ]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function kompetensi()
    {
        $user = auth()->user();

        // Core: IDs 1-5, Managerial: IDs 6-10 (based on seeder order)
        $coreCompetencies = \App\Models\Competence::with('questions')->whereBetween('id', [1, 5])->get();
        $managerialCompetencies = \App\Models\Competence::with('questions')->where('id', '>', 5)->get();
        $allCompetencies = \App\Models\Competence::with('questions')->get();

        $positions = \App\Models\Position::whereNotIn('position_name', ['Super Admin', 'Board of Directors'])->orderBy('grade_level')->get();

        // Build a lookup: [position_id][competence_id] => target_level
        $targetScores = \App\Models\PositionTargetCompetence::all()
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
                \App\Models\PositionTargetCompetence::updateOrCreate(
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

    public function mentor()
    {
        $user = auth()->user();
        $talents = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('role_name', 'talent');
        })->with(['position', 'department', 'company'])->get();

        $mentors = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('role_name', 'mentor');
        })->with(['position', 'department', 'company'])->get();

        $finances = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('role_name', 'finance');
        })->with(['position', 'department', 'company'])->get();

        $bods = \App\Models\User::whereHas('roles', function ($q) {
            $q->whereIn('role_name', ['bo_director', 'bod', 'board_of_directors']);
        })->with(['position', 'department', 'company'])->get();

        $departments = \App\Models\Department::all();
        $positions = \App\Models\Position::all();
        $rolesData = \App\Models\Role::all(); // Provide all roles for the assign modal

        return view('pdc_admin.mentor', compact('user', 'talents', 'mentors', 'finances', 'bods', 'departments', 'positions', 'rolesData'));
    }

    public function atasan()
    {
        $user = auth()->user();
        $atasans = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('role_name', 'atasan');
        })->with(['position', 'department', 'subordinates' => function ($q) {
            $q->with('position', 'promotion_plan.targetPosition');
        }])->get();

        $departments = \App\Models\Department::all();
        $positions = \App\Models\Position::all();

        return view('pdc_admin.atasan', compact('user', 'atasans', 'departments', 'positions'));
    }

    public function storeMentor(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'nama' => 'required',
            'position_id' => 'required',
            'department_id' => 'required',
            'email' => 'required|email',
        ];

        if ($id) {
            $rules['username'] = 'required|unique:users,username,' . $id;
            $rules['password'] = 'nullable|min:6';
        }
        else {
            $rules['username'] = 'required|unique:users,username';
            $rules['password'] = 'required|min:6';
        }

        $request->validate($rules);

        if ($id) {
            // Gunakan DB::table langsung agar tidak kena double-hash dari Eloquent cast 'hashed'
            $data = [
                'nama' => $request->nama,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'email' => $request->email,
                'username' => $request->username,
                'updated_at' => now(),
            ];
            if ($request->filled('password')) {
                $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
                $data['remember_token'] = $request->password;
            }
            \Illuminate\Support\Facades\DB::table('users')->where('id', $id)->update($data);
            return back()->with('success', 'Mentor berhasil diperbarui.');
        }
        else {
            $role_id = \App\Models\Role::where('role_name', 'mentor')->first()->id ?? null;
            $userId = \Illuminate\Support\Facades\DB::table('users')->insertGetId([
                'nama' => $request->nama,
                'email' => $request->email,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'company_id' => auth()->user()->company_id,
                'role_id' => $role_id,
                'username' => $request->username,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'remember_token' => $request->password,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($role_id) {
                \Illuminate\Support\Facades\DB::table('user_role')->insert([
                    'id_user' => $userId,
                    'id_role' => $role_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return back()->with('success', 'Mentor berhasil ditambahkan.');
        }
    }

    public function storeAtasan(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'nama' => 'required',
            'position_id' => 'required',
            'department_id' => 'required',
            'email' => 'required|email',
        ];

        if ($id) {
            $rules['username'] = 'required|unique:users,username,' . $id;
            $rules['password'] = 'nullable|min:6';
        }
        else {
            $rules['username'] = 'required|unique:users,username';
            $rules['password'] = 'required|min:6';
        }

        $request->validate($rules);

        if ($id) {
            // Gunakan DB::table langsung agar tidak kena double-hash dari Eloquent cast 'hashed'
            $data = [
                'nama' => $request->nama,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'email' => $request->email,
                'username' => $request->username,
                'updated_at' => now(),
            ];
            if ($request->filled('password')) {
                $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
                $data['remember_token'] = $request->password;
            }
            \Illuminate\Support\Facades\DB::table('users')->where('id', $id)->update($data);
            return back()->with('success', 'Atasan berhasil diperbarui.');
        }
        else {
            $role_id = \App\Models\Role::where('role_name', 'atasan')->first()->id ?? null;
            $userId = \Illuminate\Support\Facades\DB::table('users')->insertGetId([
                'nama' => $request->nama,
                'email' => $request->email,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'company_id' => auth()->user()->company_id,
                'role_id' => $role_id,
                'username' => $request->username,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'remember_token' => $request->password,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($role_id) {
                \Illuminate\Support\Facades\DB::table('user_role')->insert([
                    'id_user' => $userId,
                    'id_role' => $role_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return back()->with('success', 'Atasan berhasil ditambahkan.');
        }
    }

    public function requestFinanceValidation(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'notes' => 'required|string',
            'assigned_finance_id' => 'required|exists:users,id',
        ]);

        $project = \App\Models\ImprovementProject::find($request->project_id);
        if ($project) {
            $project->update([
                'status' => 'Pending',
                'feedback' => $request->notes,
                'verify_by' => $request->assigned_finance_id,
            ]);

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

    public function assignRole(Request $request, $id)
    {
        $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:role,id'
        ]);

        $user = \App\Models\User::findOrFail($id);

        // Sync roles pivot table
        $user->roles()->sync($request->roles);

        // For backward compatibility, set the primary role_id 
        if (!empty($request->roles)) {
            $user->update(['role_id' => $request->roles[0]]);
        }

        return back()->with('success', 'Manajemen Role berhasil diperbarui.');
    }
}
