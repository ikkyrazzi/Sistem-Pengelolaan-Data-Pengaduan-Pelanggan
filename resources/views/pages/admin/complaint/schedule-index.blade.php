@extends('layouts.admin.master')

@section('title', 'Technician Schedules')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Technician Schedules</h3>
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
                    <a href="#">Technician Schedules</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Technician Schedules</h4>
                            {{-- <a href="{{ route('admin.complaint.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Create New Schedule
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Complaint Subject</th>
                                        <th>Assigned Technician</th>
                                        <th>Status</th>
                                        <th>Schedule</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($complaints as $complaint)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $complaint->subject }}</td>
                                            <td>
                                                @if ($complaint->assignedTechnician)
                                                    {{ $complaint->assignedTechnician->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $complaint->status == 'completed' ? 'success' : ($complaint->status == 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($complaint->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($complaint->schedule)
                                                    {{ \Carbon\Carbon::parse($complaint->schedule)->format('d M Y') }}
                                                @else
                                                    Not Scheduled
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- <a href="{{ route('admin.complaint.show', $complaint->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('admin.complaint.schedule', $complaint->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-calendar"></i> Schedule
                                                </a> --}}
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete('{{ route('admin.complaint.destroy', $complaint->id) }}')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No technician schedules available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this technician schedule? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
