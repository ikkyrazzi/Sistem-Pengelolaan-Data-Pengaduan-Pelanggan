@extends('layouts.admin_baru.master')

@section('title', 'Complaint Manage')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Schedule Today</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Schedule Today</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Schedule List</h5>
                    <a href="{{ route('admin.send-today-schedule') }}" class="btn btn-primary">Kirim Jadwal Teknisi Hari
                        Ini</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="complaintsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Subject</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Assigned Technician</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
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
                                            <span
                                                class="badge bg-{{ $complaint->priority == 'Urgent' ? 'danger' : ($complaint->priority == 'High' ? 'warning' : ($complaint->priority == 'Medium' ? 'info' : 'success')) }}">
                                                {{ $complaint->priority }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $complaint->status == 'Completed' ? 'success' : ($complaint->status == 'Pending' ? 'warning' : 'info') }}">
                                                {{ $complaint->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($complaint->assignedTechnician)
                                                {{ $complaint->assignedTechnician->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y, H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.complaint.show', $complaint->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.complaint.schedule', $complaint->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa fa-calendar"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $complaint->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $complaint->id }}"
                                                action="{{ route('admin.complaint.destroy', $complaint->id) }}"
                                                method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No complaints found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#complaintsTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });

            $('.delete-btn').click(function() {
                let complaintId = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + complaintId).submit();
                    }
                });
            });
        });
    </script>
@endpush
