@extends('layouts.admin.master')

@section('title', 'Create New Customer')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Manage Customers</h3>
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
                    <a href="#">Create New Customer</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Create New Customer</div>
                    </div>
                    <form action="{{ route('admin.customer.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Form Group for Customer Number -->
                            <div class="form-group">
                                <label for="no_customer">Customer Number</label>
                                <input type="text" name="no_customer" class="form-control" id="no_customer"
                                    value="CP00{{ strtoupper(substr(md5(uniqid(rand(), true)), 0, 4)) }}" disabled>
                            </div>

                            <!-- Form Group for Name -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter full name" required>
                            </div>

                            <!-- Form Group for Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Enter email address" required>
                            </div>

                            <!-- Form Group for Phone -->
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone"
                                    placeholder="Enter phone number" required>
                            </div>

                            <!-- Form Group for Address -->
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="Enter address" required>
                            </div>

                            <!-- Form Group for Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Enter password" required>
                            </div>

                            <!-- Form Group for Confirm Password -->
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" placeholder="Confirm password" required>
                            </div>

                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('admin.customer.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
