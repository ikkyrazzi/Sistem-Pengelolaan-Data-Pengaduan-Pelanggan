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
        $currentYear = Carbon::now()->year;

        $usersCount = User::count();
        $techniciansCount = Technician::count();
        $complaintsCount = Complaint::whereDate('created_at', Carbon::today())->count();
        $customersCount = Customer::count();

        $recentComplaints = Complaint::with('customer.customerDetail')->latest()->take(5)->get();

        $categories = ['Gangguan Jaringan', 'Perangkat Rusak', 'Administrasi', 'Layanan TV', 'Gangguan Telepon', 'Lainnya'];
        $complaintsByCategory = [];

        foreach ($categories as $category) {
            $monthlyCounts = [];
            for ($month = 1; $month <= 12; $month++) {
                $monthlyCounts[] = Complaint::where('category', $category)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count();
            }
            $complaintsByCategory[] = [
                'category' => $category,
                'data' => $monthlyCounts,
            ];
        }

        return view('pages.admin_baru.dashboard', [
            'usersCount' => $usersCount,
            'techniciansCount' => $techniciansCount,
            'complaintsCount' => $complaintsCount,
            'customersCount' => $customersCount,
            'recentComplaints' => $recentComplaints,
            'complaintsByCategory' => $complaintsByCategory,
            'currentYear' => $currentYear,
        ]);
    }
}
