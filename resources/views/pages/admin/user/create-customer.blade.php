@extends('layouts.admin.master')

@section('title', 'Profile Content')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Manage Users</h3>
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
                    <a href="{{ route('admin.user.index') }}">Manage Users</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Profile Content</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Profile Content</div>
                    </div>
                    <form action="{{ route('admin.user.store-customer', $user->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Form Group for Customer Number -->
                            <div class="form-group">
                                <label for="no_customer">Customer Number</label>
                                <input type="text" name="no_customer" class="form-control" id="no_customer"
                                    value="CP00{{ strtoupper(substr(md5(uniqid(rand(), true)), 0, 4)) }}" disabled>
                            </div>

                            <!-- Form Group for Address -->
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" id="address" placeholder="Enter address" required></textarea>
                            </div>

                            <!-- Form Group for Phone -->
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone"
                                    placeholder="Enter phone number" required>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
