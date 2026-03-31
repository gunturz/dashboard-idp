<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        return view('finance.dashboard', compact('user'));
    }

    public function permintaanValidasi()
    {
        $user = auth()->user();
        return view('finance.permintaan_validasi', compact('user'));
    }
}
