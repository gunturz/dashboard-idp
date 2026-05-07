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
            ->orderBy('updated_at', 'desc')
            ->get();

        $total = $projects->count();
        // Pending = Finance belum memberi keputusan
        $pending = $projects->filter(fn($p) => $p->status === 'Pending' && !$p->finance_feedback)->count();
        $approved = $projects->filter(fn($p) => str_starts_with($p->finance_feedback ?? '', '[Approved]'))->count();
        $rejected = $projects->filter(fn($p) => str_starts_with($p->finance_feedback ?? '', '[Rejected]'))->count();

        // Belum beri keputusan
        $pendingProjects = $projects->filter(fn($p) => $p->status === 'Pending' && !$p->finance_feedback);
        // Sudah beri keputusan
        $historyProjects = $projects->filter(fn($p) => str_starts_with($p->finance_feedback ?? '', '[Approved]') || str_starts_with($p->finance_feedback ?? '', '[Rejected]'));

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

        // Tampilkan semua project yang dikirim ke finance ini (feedback = ada), belum ada keputusan dari Finance
        $projects = ImprovementProject::with(['talent.position', 'talent.department', 'talent.promotion_plan.targetPosition'])
            ->whereHas('talent.promotion_plan', function ($q) {
                $q->whereNotIn('status_promotion', ['Promoted', 'Not Promoted']);
            })
            ->whereNotNull('feedback')
            ->where('verify_by', $user->id)
            ->where('status', 'Pending')
            ->whereNull('finance_feedback')
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

        // Riwayat = project yang sudah diberi keputusan oleh Finance (ada [Approved] atau [Rejected] di finance_feedback)
        $projectsQuery = ImprovementProject::with(['talent.position', 'talent.department', 'talent.company', 'talent.promotion_plan.targetPosition'])
            ->whereNotNull('feedback')
            ->where('verify_by', $user->id)
            ->where(function ($q) {
            $q->where('finance_feedback', 'like', '[Approved]%')
                ->orWhere('finance_feedback', 'like', '[Rejected]%');
        })
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
        $user = auth()->user();

        $request->validate([
            'finance_decision' => 'required|in:Approved,Rejected',
            'finance_feedback' => 'nullable|string'
        ]);

        $project = ImprovementProject::findOrFail($id);

        // Finance menyimpan keputusan & feedback
        // Format: '[Approved] catatan...' atau '[Rejected] catatan...'
        $decision = $request->finance_decision;
        $feedbackText = $request->finance_feedback ?? '';
        $stored = '[' . $decision . ']' . ($feedbackText ? ' ' . $feedbackText : '');

        $dbStatus = $decision === 'Approved' ? 'Verified' : 'Rejected';

        $project->update([
            'finance_feedback' => $stored,
            'status' => $dbStatus,
            'verify_by' => $user->id,
            'verify_at' => now(),
        ]);

        // Notifikasi ke seluruh PDC Admin bahwa Finance sudah memberi keputusan
        $pdcAdminIds = \App\Models\User::whereHas('roles', fn($q) => $q->where('role_name', 'admin'))->pluck('id');

        foreach ($pdcAdminIds as $adminId) {
            $this->addNotificationToUser(
                $adminId,
                'Validasi Finance Diterima',
                'Finance (<strong>' . ($user->nama ?? $user->name) . '</strong>) telah memberikan keputusan <span class="font-semibold">' . $decision . '</span> untuk Project Improvement milik <strong>' . ($project->talent->nama ?? '-') . '</strong>.',
                $decision === 'Approved' ? 'success' : 'warning'
            );
        }

        // Notifikasi langsung ke Talent dari keputusan Finance
        $this->addNotificationToUser(
            $project->user_id_talent,
            'Keputusan Project Improvement dari Finance',
            'Finance telah meninjau dan memperbarui Project Improvement Anda menjadi <span class="font-semibold">' . $dbStatus . '</span>.' . ($feedbackText ? ' Catatan: <em>' . e($feedbackText) . '</em>' : ''),
            $dbStatus === 'Verified' ? 'success' : 'warning'
        );

        return redirect()->route('finance.riwayat')->with('success', 'Keputusan validasi finance berhasil disimpan dan diteruskan ke Talent.');
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
