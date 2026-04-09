<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImprovementProject;

class FinanceDashboardController extends Controller
{
    /**
     * Build Finance notifications (mockup, can be replaced with real data)
     */
    protected function getNotifications()
    {
        return collect([]);
    }

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

        $notifications = $this->getNotifications();

        return view('finance.dashboard', compact('user', 'projects', 'total', 'pending', 'approved', 'rejected', 'groupedPendingProjects', 'groupedHistoryProjects', 'companies'))
            ->with('notifications', $notifications);
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

        $notifications = $this->getNotifications();

        return view('finance.permintaan_validasi', compact('user', 'projects'))
            ->with('notifications', $notifications);
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

        $notifications = $this->getNotifications();

        return view('finance.riwayat', compact('user', 'projects', 'companies', 'groupedHistoryProjects', 'search'))
            ->with('notifications', $notifications);
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

        $this->addNotificationToUser(
            $project->user_id_talent,
            'Project ' . $request->status,
            'Project Improvement Anda telah diperbarui menjadi <span class="font-semibold">' . $request->status . '</span> oleh Finance' . ($request->finance_feedback ? ' dengan catatan: ' . $request->finance_feedback : '.'),
            $request->status == 'Verified' ? 'success' : 'warning'
        );

        return back()->with('success', 'Status validasi berhasil diperbarui.');
    }

    /**
     * Finance Notifikasi — full notification page.
     */
    public function notifikasi()
    {
        $user = auth()->user();
        $notifications = $this->getNotifications();

        return view('finance.notifikasi', compact('user', 'notifications'));
    }

    /**
     * Mark all Finance notifications as read.
     */
    public function markAllNotificationsRead(Request $request)
    {
        return back();
    }
}
