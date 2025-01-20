@extends('layouts.admin.master')

@section('title', 'Customer Details')

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
                    <a href="#">User Details</a>
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
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    @if ($user->roles->isEmpty())
                                        Tidak ada role
                                    @else
                                        @foreach ($user->roles as $role)
                                            {{ $role->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            @if ($user->customer)
                                <tr>
                                    <th>No Customer</th>
                                    <td>{{ $user->customer->no_customer }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $user->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $user->customer->address }}</td>
                                </tr>
                            @elseif ($user->Technician)
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $user->technician->phone }}</td>
                                </tr>
                            @else
                                <tr>
                                    {{-- <th>No Customer Data</th> --}}
                                    <td colspan="2">Not Roles Customers and Technicians.</td>
                                </tr>
                            @endif
                        </table>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
