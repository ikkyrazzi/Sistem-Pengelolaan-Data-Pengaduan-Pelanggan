@extends('layouts.admin_baru.master')

@section('title', 'Complaint Details')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Complaint Details</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Complaint Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Complaint Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Customer</th>
                            <td>{{ $complaint->customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Subject</th>
                            <td>{{ $complaint->subject }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $complaint->description }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $complaint->category }}</td>
                        </tr>
                        <tr>
                            <th>Priority</th>
                            <td>
                                <span
                                    class="badge bg-{{ $complaint->priority == 'Urgent' ? 'danger' : ($complaint->priority == 'High' ? 'warning' : ($complaint->priority == 'Medium' ? 'info' : 'success')) }}">
                                    {{ $complaint->priority }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span
                                    class="badge bg-{{ $complaint->status == 'Completed' ? 'success' : ($complaint->status == 'Pending' ? 'warning' : 'info') }}">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Assigned Technician</th>
                            <td>
                                @if ($complaint->assignedTechnician)
                                    {{ $complaint->assignedTechnician->name }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                    <a href="{{ route('admin.complaint.schedule-index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
