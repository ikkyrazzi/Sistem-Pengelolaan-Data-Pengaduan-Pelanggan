@extends('layouts.admin.master')

@section('title', 'Manage Customers')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Manage Customers</h3>
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
                    <a href="#">Manage Customers</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">List of Customers</h4>
                            <a href="{{ route('admin.customer.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Create New Customer
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>No Customer</th> <!-- Add No Customer column -->
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $customer->no_customer }}</td> <!-- Display No Customer -->
                                            <td>{{ $customer->user->name }}</td>
                                            <td>{{ $customer->user->email }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.customer.show', $customer->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> Details Profile
                                                </a>
                                                <a href="{{ route('admin.customer.edit', $customer->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ route('admin.customer.editPassword', $customer->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-key"></i> Change Password
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete('{{ route('admin.customer.destroy', $customer->id) }}')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No customers available.</td>
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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

@push('script')
    <script>
        function confirmDelete(url) {
            var modal = $('#deleteModal');
            modal.find('form').attr('action', url);
            modal.modal('show');
        }
    </script>
@endpush
