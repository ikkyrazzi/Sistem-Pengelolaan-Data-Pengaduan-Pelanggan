<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Technician;
use App\Models\Complaint;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index()
    {
        // Get counts for users, technicians, complaints, and customers
        $usersCount = User::count();
        $techniciansCount = Technician::count();
        $complaintsCount = Complaint::count();
        $customersCount = Customer::count();

        // Get recent complaints (for example, the last 5)
        $recentComplaints = Complaint::latest()->take(5)->get();

        // Complaints per month
        $complaintsPerMonth = Complaint::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Complaints per category (Gangguan, Instalasi, Tagihan)
        $categories = ['Gangguan', 'Instalasi', 'Tagihan', 'Lainnya'];
        $complaintsByCategory = [];

        foreach ($categories as $category) {
            $monthlyCounts = [];
            // Get complaints count for each category by month
            for ($month = 1; $month <= 12; $month++) {
                $monthlyCounts[] = Complaint::where('category', $category)
                    ->whereMonth('created_at', $month)
                    ->count();
            }
            $complaintsByCategory[] = [
                'category' => $category,
                'data' => $monthlyCounts,
            ];
        }

        // Pass the data to the view
        return view('pages.admin.dashboard', [
            'usersCount' => $usersCount,
            'techniciansCount' => $techniciansCount,
            'complaintsCount' => $complaintsCount,
            'customersCount' => $customersCount,
            'recentComplaints' => $recentComplaints,
            'complaintsPerMonth' => $complaintsPerMonth,
            'complaintsByCategory' => $complaintsByCategory, // Pass category data to view
        ]);
    }
}
