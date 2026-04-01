<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImprovementProject;

class FinanceDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $projects = ImprovementProject::with(['talent.position', 'talent.department', 'talent.company', 'talent.promotion_plan.targetPosition'])
            ->whereNotNull('feedback')
            ->where('verify_by', $user->id)
            ->orderByRaw("FIELD(status, 'Pending', 'On Progress', 'Verified', 'Rejected')")
            ->orderBy('updated_at', 'desc')
            ->get();

        $total = $projects->count();
        $pending = $projects->whereIn('status', ['Pending', 'On Progress'])->count();
        $approved = $projects->where('status', 'Verified')->count();
        $rejected = $projects->where('status', 'Rejected')->count();

        $pendingProjects = $projects->whereIn('status', ['Pending', 'On Progress']);
        $historyProjects = $projects->whereIn('status', ['Verified', 'Rejected']);

        $companies = $projects->pluck('talent.company.nama_company')->filter()->unique()->values();

        $groupedPendingProjects = $pendingProjects->groupBy(function ($item) {
            return $item->talent->company->nama_company ?? 'Perusahaan Tidak Diketahui';
        });

        $groupedHistoryProjects = $historyProjects->groupBy(function ($item) {
            return $item->talent->company->nama_company ?? 'Perusahaan Tidak Diketahui';
        });

        return view('finance.dashboard', compact('user', 'projects', 'total', 'pending', 'approved', 'rejected', 'groupedPendingProjects', 'groupedHistoryProjects', 'companies'));
    }

    public function permintaanValidasi()
    {
        $user = auth()->user();

        $projects = ImprovementProject::with(['talent.position', 'talent.department'])
            ->whereIn('status', ['Pending', 'On Progress'])
            ->whereNotNull('feedback')
            ->where('verify_by', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('finance.permintaan_validasi', compact('user', 'projects'));
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $projectsQuery = ImprovementProject::with(['talent.position', 'talent.department', 'talent.company', 'talent.promotion_plan.targetPosition'])
            ->whereNotNull('feedback')
            ->whereIn('status', ['Verified', 'Rejected'])
            ->where('verify_by', $user->id)
            ->orderBy('updated_at', 'desc');

        if ($search) {
            $projectsQuery->whereHas('talent', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            });
        }

        $projects = $projectsQuery->get();

        $companies = $projects->pluck('talent.company.nama_company')->filter()->unique()->values();

        $groupedHistoryProjects = $projects->groupBy(function ($item) {
            return $item->talent->company->nama_company ?? 'Perusahaan Tidak Diketahui';
        });

        return view('finance.riwayat', compact('user', 'projects', 'companies', 'groupedHistoryProjects', 'search'));
    }

    public function updateFinanceValidation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Verified,Rejected',
            'finance_feedback' => 'nullable|string'
        ]);

        $project = ImprovementProject::findOrFail($id);

        $project->update([
            'status' => $request->status,
            'finance_feedback' => $request->finance_feedback, // feedback dari finance
            'verify_by' => auth()->id(),
            'verify_at' => now(),
        ]);

        return back()->with('success', 'Status validasi berhasil diperbarui.');
    }
}
