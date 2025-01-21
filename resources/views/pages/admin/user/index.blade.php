@extends('layouts.admin.master')

@section('title', 'Home Page')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Manage Users</h3>
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
                    <a href="#">Manage Users</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">List Data</h4>
                            {{-- <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Create New User
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->customer)
                                                    {{ $user->customer->phone }}
                                                @elseif ($user->technician)
                                                    {{ $user->technician->phone }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.user.show', $user->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> Details Profile
                                                </a>
                                                {{-- <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a> --}}
                                                <a href="{{ route('admin.user.change-password-form', $user->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-key"></i> Change Password
                                                </a>
                                                {{-- @if ($user->hasRole('Technician'))
                                                    <a href="{{ route('admin.user.create-technician', $user->id) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        <i class="fa fa-user"></i> Profile Technician
                                                    </a>
                                                @elseif ($user->hasRole('Customer'))
                                                    <a href="{{ route('admin.user.create-customer', $user->id) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        <i class="fa fa-user"></i> Profile Customer
                                                    </a>
                                                @endif --}}
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete('{{ route('admin.user.destroy', $user->id) }}')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data pengguna.</td>
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
    <!-- Modal -->
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
                    Are you sure you want to delete this customer? This action cannot be undone.
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
