@extends('layouts.admin.master')

@section('title', 'Technician Details')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Technician Details</h3>
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
                    <a href="{{ route('admin.technician.index') }}">Technician List</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Technician Details</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Technician Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td>{{ $technician->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $technician->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $technician->phone }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('admin.technician.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
