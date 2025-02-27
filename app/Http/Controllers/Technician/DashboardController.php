<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Get the logged-in technician's ID
        $today = Carbon::today();

        // Complaints berdasarkan status (keseluruhan)
        $inProgressComplaints = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'in_progress')
            ->count();

        $resolvedComplaints = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'completed')
            ->count();

        $pendingComplaints = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'pending')
            ->count();

        // Complaints berdasarkan status (hari ini)
        $inProgressToday = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'in_progress')
            ->whereDate('schedule', $today)
            ->count();

        $resolvedToday = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'completed')
            ->whereDate('schedule', $today)
            ->count();

        $pendingToday = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'pending')
            ->whereDate('schedule', $today)
            ->count();

        $totalComplaintsToday = Complaint::where('assigned_technician_id', $userId)
            ->whereDate('schedule', $today)
            ->count();

        // Get recent complaints assigned to this technician for today
        $recentComplaints = Complaint::where('assigned_technician_id', $userId)
            ->whereDate('schedule', $today)
            ->latest()
            ->take(5)
            ->get();

        return view('pages.technician_baru.dashboard', [
            'inProgressComplaints' => $inProgressComplaints,
            'resolvedComplaints' => $resolvedComplaints,
            'pendingComplaints' => $pendingComplaints,
            'inProgressToday' => $inProgressToday,
            'resolvedToday' => $resolvedToday,
            'pendingToday' => $pendingToday,
            'totalComplaintsToday' => $totalComplaintsToday,
            'recentComplaints' => $recentComplaints,
        ]);
    }
}
