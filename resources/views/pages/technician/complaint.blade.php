@extends('layouts.technician.master')

@section('title', 'Daftar Keluhan')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Complaint List</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('technician.complaints') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Complaint List</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assigned Complaints</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
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
                                    @if ($complaints->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada keluhan yang tersedia.</td>
                                        </tr>
                                    @else
                                        @foreach ($complaints as $complaint)
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
                                                <td>{{ $complaint->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('technician.complaints.updateStatus', $complaint->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <select name="status" class="form-control form-control-sm mb-2">
                                                            <option value="pending"
                                                                {{ $complaint->status == 'pending' ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="in_progress"
                                                                {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>
                                                                In Progress</option>
                                                            <option value="completed"
                                                                {{ $complaint->status == 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                        </select>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $complaints->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
