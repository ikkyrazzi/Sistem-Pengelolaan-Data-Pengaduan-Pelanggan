@extends('layouts.admin.master')

@section('title', 'Manage Complaints')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Manage Complaints</h3>
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
                    <a href="#">Manage Complaints</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">List Complaints</h4>
                            {{-- <a href="{{ route('admin.complaint.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Create New Complaint
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Customer</th>
                                        <th>Subject</th>
                                        <th>Category</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Assigned Technician</th>
                                        <th>Created At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($complaints as $complaint)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $complaint->customer->name }}</td>
                                            <td>{{ $complaint->subject }}</td>
                                            <td>{{ $complaint->category }}</td>
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
                                            <td>
                                                <span
                                                    class="badge badge-{{ $complaint->status == 'completed' ? 'success' : ($complaint->status == 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($complaint->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($complaint->assignedTechnician)
                                                    {{ $complaint->assignedTechnician->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{ $complaint->created_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.complaint.show', $complaint->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                {{-- <a href="{{ route('admin.complaint.edit', $complaint->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a> --}}
                                                <a href="{{ route('admin.complaint.schedule', $complaint->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-calendar"></i> Schedule
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete('{{ route('admin.complaint.destroy', $complaint->id) }}')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No complaints available.</td>
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
                    Are you sure you want to delete this complaint? This action cannot be undone.
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

    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({
                "order": [
                    [7, "desc"]
                ]
            });
        });
    </script>
@endsection
