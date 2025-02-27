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
                        <li class="breadcrumb-item active" aria-current="page">Complaint Manage</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Complaint Management</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Complaint List</h5>
                    <a href="{{ route('admin.complaint.export') }}" class="btn btn-success">Export</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="complaintsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Customer</th>
                                    <th>Name</th>
                                    <th>Complaint</th>
                                    <th>Assigned Technician</th>
                                    <th>Status</th>
                                    <th>Schedule</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($complaints as $complaint)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $complaint->customer->customerDetail->no_customer ?? 'Unknown' }}</td>
                                        <td>{{ $complaint->customer->name }}</td>
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
                                                class="badge bg-{{ $complaint->status == 'Completed' ? 'success' : ($complaint->status == 'Pending' ? 'warning' : 'info') }}">
                                                {{ $complaint->status }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($complaint->schedule)->format('d M Y') }}</td>
                                        <td>
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
                                @endforeach
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
