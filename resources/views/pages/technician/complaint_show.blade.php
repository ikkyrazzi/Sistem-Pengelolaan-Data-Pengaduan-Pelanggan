@extends('layouts.technician.master')

@section('title', 'Complaint Details')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Complaint Details</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('technician.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('technician.schedule') }}">Schedule Complaint</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Complaint Details</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Complaint Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
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
                                    @php
                                        $priorityClass = '';
                                        switch (strtolower($complaint->priority)) {
                                            case 'high':
                                                $priorityClass = 'badge badge-danger';
                                                break;
                                            case 'medium':
                                                $priorityClass = 'badge badge-warning';
                                                break;
                                            case 'low':
                                                $priorityClass = 'badge badge-success';
                                                break;
                                            default:
                                                $priorityClass = 'badge badge-secondary';
                                                break;
                                        }
                                    @endphp
                                    <span
                                        class="{{ $priorityClass }} rounded-pill">{{ ucfirst($complaint->priority) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span
                                        class="badge badge-{{ $complaint->status == 'completed' ? 'success' : ($complaint->status == 'pending' ? 'secondary' : 'warning') }} rounded-pill">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                </td>
                            </tr>
                            @if ($complaint->assignedTechnician)
                                <tr>
                                    <th>Assigned Technician</th>
                                    <td><strong>{{ $complaint->assignedTechnician->name }}</strong></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2">No technician assigned yet.</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Schedule</th>
                                <td>{{ $complaint->schedule }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('technician.schedule') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
