<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint; // Model untuk pengaduan

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data statistik pengaduan berdasarkan status
        $resolvedComplaints = Complaint::where('customer_id', auth()->id())
            ->where('status', 'completed')
            ->count();

        $pendingComplaints = Complaint::where('customer_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        $inProgressComplaints = Complaint::where('customer_id', auth()->id())
            ->where('status', 'in_progress')
            ->count();

        $totalComplaints = Complaint::where('customer_id', auth()->id())->count();

        $recentComplaints = Complaint::where('customer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.customer.dashboard', compact(
            'resolvedComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'totalComplaints',
            'recentComplaints'
        ));
    }
}
