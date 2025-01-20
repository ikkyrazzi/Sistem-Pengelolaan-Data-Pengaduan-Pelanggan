@extends('layouts.technician.master')

@section('title', 'Complaint History')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Complaint History</h3>
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
                    <a href="#">Complaint History</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of Completed Complaints</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($completedComplaints->count())
                                        @foreach ($completedComplaints as $complaint)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $complaint->subject }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $complaint->status == 'completed' ? 'success' : 'info' }}">
                                                        {{ ucfirst($complaint->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $complaint->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No completed complaints found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
