@extends('layouts.admin.master')

@section('title', 'Customer Details')

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
                    <a href="#">Customer Details</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customer Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>No Customer</th>
                                <td>{{ $customer->no_customer }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $customer->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $customer->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $customer->address }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
