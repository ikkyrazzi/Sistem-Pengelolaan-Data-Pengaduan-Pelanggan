@extends('layouts.admin_baru.master')

@section('title', 'Technician Change Password')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Management</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.technician.index') }}">Technician Manage</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Technician Change Password</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Technician Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.technician.updatePassword', $technician->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-key me-1"></i> New Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Enter new password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label"><i class="fas fa-check-double me-1"></i>
                                Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Confirm new password" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Update Password
                            </button>
                            <a href="{{ route('admin.technician.index') }}" class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
