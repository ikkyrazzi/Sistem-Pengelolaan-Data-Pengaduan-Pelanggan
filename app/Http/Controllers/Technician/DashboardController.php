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

        // Filter complaints based on technician's ID
        $inProgressComplaints = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'in_progress')
            ->count();

        $resolvedComplaints = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'completed')
            ->count();

        $pendingComplaints = Complaint::where('assigned_technician_id', $userId)
            ->where('status', 'pending')
            ->count();

        // Get recent complaints assigned to this technician for today
        $recentComplaints = Complaint::where('assigned_technician_id', $userId)
            ->whereDate('schedule', $today)  // Filter by today's date
            ->latest()
            ->take(5)
            ->get();

        return view('pages.technician.dashboard', [
            'inProgressComplaints' => $inProgressComplaints,
            'resolvedComplaints' => $resolvedComplaints,
            'pendingComplaints' => $pendingComplaints,
            'recentComplaints' => $recentComplaints,
        ]);
    }
}
