<?php

use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\ComplaintController as CustomerComplaintController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Technician\ComplaintController as TechnicianComplaintController;
use App\Http\Controllers\Technician\DashboardController as TechnicianDashboardController;
use App\Http\Controllers\Technician\ProfileController as TechnicianProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Customer
    Route::middleware('role:Customer')->group(function () {
        Route::get('pages/customer/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
        Route::patch('pages/customer/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
        Route::delete('pages/customer/profile', [CustomerProfileController::class, 'destroy'])->name('customer.profile.destroy');

        Route::get('pages/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
        Route::get('pages/customer/history-complaint', [CustomerComplaintController::class, 'index'])->name('customer.history.complaint');
        Route::get('pages/customer/create-complaint', [CustomerComplaintController::class, 'create'])->name('customer.create.complaint');
        Route::post('pages/customer/store-complaint', [CustomerComplaintController::class, 'store'])->name('customer.store.complaint');
    });

    // Rute untuk Admin
    Route::middleware('role:Admin')->group(function () {
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('pages/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('pages/admin/user', UserController::class)
            ->names([
                'index' => 'admin.user.index',
                'create' => 'admin.user.create',
                'store' => 'admin.user.store',
                'edit' => 'admin.user.edit',
                'update' => 'admin.user.update',
                'show' => 'admin.user.show',
                'destroy' => 'admin.user.destroy',
            ]);

        Route::resource('pages/admin/customer', CustomerController::class)
            ->names([
                'index' => 'admin.customer.index',
                'create' => 'admin.customer.create',
                'store' => 'admin.customer.store',
                'edit' => 'admin.customer.edit',
                'update' => 'admin.customer.update',
                'show' => 'admin.customer.show',
                'destroy' => 'admin.customer.destroy',
            ]);

        // Route untuk change password
        Route::get('pages/admin/customer/{customer}/change-password', [CustomerController::class, 'editPassword'])->name('admin.customer.editPassword');
        Route::post('pages/admin/customer/{customer}/change-password', [CustomerController::class, 'updatePassword'])->name('admin.customer.updatePassword');

        Route::resource('pages/admin/technician', TechnicianController::class)
            ->names([
                'index' => 'admin.technician.index',
                'create' => 'admin.technician.create',
                'store' => 'admin.technician.store',
                'edit' => 'admin.technician.edit',
                'update' => 'admin.technician.update',
                'show' => 'admin.technician.show',
                'destroy' => 'admin.technician.destroy',
            ]);

        Route::get('pages/admin/technician/{technician}/change-password', [TechnicianController::class, 'editPassword'])->name('admin.technician.editPassword');
        Route::post('pages/admin/technician/{technician}/change-password', [TechnicianController::class, 'updatePassword'])->name('admin.technician.updatePassword');

        // Tambahan Route untuk Change Password
        Route::get('pages/admin/user/{user}/change-password', [UserController::class, 'changePasswordForm'])->name('admin.user.change-password-form');
        Route::post('pages/admin/user/{user}/change-password', [UserController::class, 'changePassword'])->name('admin.user.change-password');

        // Route untuk Create Customer
        Route::get('pages/admin/user/{user}/create-customer', [UserController::class, 'createCustomer'])->name('admin.user.create-customer');
        Route::post('pages/admin/user/{user}/store-customer', [UserController::class, 'storeCustomer'])->name('admin.user.store-customer');

        // Route untuk Create Technician
        Route::get('pages/admin/user/{user}/create-technician', [UserController::class, 'createTechnician'])->name('admin.user.create-technician');
        Route::post('pages/admin/user/{user}/store-technician', [UserController::class, 'storeTechnician'])->name('admin.user.store-technician');

        Route::get('admin/send-today-schedule', [ComplaintController::class, 'sendTodaySchedule'])->name('admin.send-today-schedule');

        Route::resource('pages/admin/complaint', ComplaintController::class)
            ->names([
                'index' => 'admin.complaint.index',
                'create' => 'admin.complaint.create',
                'store' => 'admin.complaint.store',
                'edit' => 'admin.complaint.edit',
                'update' => 'admin.complaint.update',
                'show' => 'admin.complaint.show',
                'destroy' => 'admin.complaint.destroy',
            ]);

        Route::get('admin/complaint/schedule/{complaint}', [ComplaintController::class, 'schedule'])->name('admin.complaint.schedule');
        Route::post('admin/complaint/schedule/{complaint}', [ComplaintController::class, 'scheduleUpdate'])->name('admin.complaint.schedule.update');
        Route::get('admin/complaints/schedule', [ComplaintController::class, 'scheduleIndex'])->name('admin.complaint.schedule-index');

        Route::get('admin/complaints/export', [ComplaintController::class, 'export'])->name('admin.complaint.export');
    });

    // Rute untuk Technician
    Route::middleware('role:Technician')->group(function () {
        Route::get('pages/technician/profile', [TechnicianProfileController::class, 'edit'])->name('technician.profile.edit');
        Route::patch('pages/technician/profile', [TechnicianProfileController::class, 'update'])->name('technician.profile.update');
        Route::delete('pages/technician/profile', [TechnicianProfileController::class, 'destroy'])->name('technician.profile.destroy');

        Route::get('pages/technician/dashboard', [TechnicianDashboardController::class, 'index'])->name('technician.dashboard');
        Route::get('pages/technician/manage-tasks', [TechnicianDashboardController::class, 'manageTasks'])->name('technician.manage-tasks');

        Route::get('pages/technician/complaint', [TechnicianComplaintController::class, 'complaints'])->name('technician.complaints');
        Route::get('pages/technician/schedule', [TechnicianComplaintController::class, 'schedule'])->name('technician.schedule');
        Route::get('complaints/{complaint}', [TechnicianComplaintController::class, 'show'])->name('technician.complaints.show');
        Route::get('pages/technician/history', [TechnicianComplaintController::class, 'history'])->name('technician.history');
        Route::post('pages/technician/complaints/{id}/update-status', [TechnicianComplaintController::class, 'updateStatus'])->name('technician.complaints.updateStatus');
    });
});

require __DIR__ . '/auth.php';
