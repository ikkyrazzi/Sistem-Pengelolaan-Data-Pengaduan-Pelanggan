@extends('layouts.admin_baru.master')

@section('title', 'Technician Details')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Technician Details</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Technician Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <h5 class="mb-0 fw-bold">Technician Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 60px; height: 60px; font-size: 24px;">
                            {{ strtoupper(substr($technician->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-1 fw-bold">{{ $technician->user->name }}</h4>
                            <p class="text-muted mb-0"><i class="fas fa-envelope me-1"></i> {{ $technician->user->email }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong><i class="fas fa-phone-alt me-1"></i> Phone:</strong>
                            <span>{{ $technician->phone }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-light text-end py-3">
                    <a href="{{ route('admin.technician.edit', $technician->id) }}" class="btn btn-warning px-4">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.technician.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
