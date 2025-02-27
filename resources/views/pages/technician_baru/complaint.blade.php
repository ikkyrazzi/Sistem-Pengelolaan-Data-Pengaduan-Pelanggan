@extends('layouts.technician_baru.master')

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
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="complaintsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject</th>
                                    <th>Deskription</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($complaints as $complaint)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $complaint->subject }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($complaint->description, 50) }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $complaint->status == 'completed' ? 'success' : ($complaint->status == 'pending' ? 'warning' : 'primary') }}">
                                                {{ ucfirst($complaint->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $complaint->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <form action="{{ route('technician.complaints.updateStatus', $complaint->id) }}"
                                                method="POST">
                                                @csrf
                                                <select name="status" class="form-control form-control-sm mb-2">
                                                    <option value="pending"
                                                        {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="in_progress"
                                                        {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In
                                                        Progress</option>
                                                    <option value="completed"
                                                        {{ $complaint->status == 'completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
