@extends('layouts.technician_baru.master')

@section('title', 'My Profile')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">My Profile</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <h5 class="mb-0 fw-bold">Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        @include('pages.technician_baru.profile.partials.update-profile-information-form')
                    </div>
                    <hr>
                    <div class="mb-4">
                        @include('pages.technician_baru.profile.partials.update-password-form')
                    </div>
                    <hr>
                    <div>
                        @include('pages.technician_baru.profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
