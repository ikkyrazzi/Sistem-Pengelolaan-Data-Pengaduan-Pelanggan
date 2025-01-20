@extends('layouts.admin.master')

@section('title', 'Change Password')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Change Password for Customer</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customer.index') }}">Manage Customers</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Change Password</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Change Password for Customer</div>
                    </div>
                    <form action="{{ route('admin.customer.updatePassword', $customer->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Form Group for Password -->
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Enter new password" required>
                            </div>

                            <!-- Form Group for Confirm Password -->
                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" placeholder="Confirm new password" required>
                            </div>

                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update Password</button>
                            <a href="{{ route('admin.customer.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
