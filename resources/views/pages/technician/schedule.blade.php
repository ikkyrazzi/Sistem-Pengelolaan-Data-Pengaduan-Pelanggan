@extends('layouts.technician.master')

@section('title', 'Schedule Complaints')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Schedule Complaints</h3>
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
                    <a href="#">Schedule Complaints</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Today's Schedule</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Scheduled At</th>
                                        <th>Action</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($scheduledComplaints)
                                        @foreach ($scheduledComplaints as $complaint)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $complaint->subject }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($complaint->description, 50) }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $complaint->status == 'completed' ? 'success' : ($complaint->status == 'pending' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($complaint->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $complaint->schedule }}</td>
                                                <td>
                                                    @if ($complaint->status !== 'completed')
                                                        <form method="POST"
                                                            action="{{ route('technician.complaints.updateStatus', $complaint->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                Mark as Completed
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-secondary btn-sm" disabled>
                                                            Completed
                                                        </button>
                                                    @endif
                                                </td>
                                                <!-- Added Details Button -->
                                                <td>
                                                    <a href="{{ route('technician.complaints.show', $complaint->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No complaints scheduled for today.</td>
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
