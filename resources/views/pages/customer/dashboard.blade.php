@extends('layouts.customer.master')

@section('title', 'Customer Dashboard')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard Customer</h3>
                <p class="text-muted">Welcome back, {{ auth()->user()->name }}! Here's a summary of your complaints, their
                    current status, and other activities to keep you informed and up to date.</p>
            </div>
        </div>
        <div class="row">
            <!-- Total Complaints -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-list"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Complaints</p>
                                    <h4 class="card-title">{{ $totalComplaints }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- In Progress -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-spinner"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">In Progress</p>
                                    <h4 class="card-title">{{ $inProgressComplaints }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Resolved -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Resolved</p>
                                    <h4 class="card-title">{{ $resolvedComplaints }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-danger bubble-shadow-small">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pending</p>
                                    <h4 class="card-title">{{ $pendingComplaints }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Complaints -->
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Recent Complaints</div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($recentComplaints->isEmpty())
                            <p class="text-muted">No recent complaints found.</p>
                        @else
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentComplaints as $complaint)
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Tips -->
            <div class="col-md-4">
                <div class="card card-primary card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Troubleshooting Tips</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Matikan modem dengan menekan tombol power atau cabut kabel daya.</li>
                            <li>Tunggu selama 10-30 detik agar modem benar-benar mati.</li>
                            <li>Hidupkan kembali modem dengan menyambungkan kabel daya atau menekan tombol power.</li>
                            <li>Tunggu beberapa menit hingga modem selesai booting dan lampu indikator stabil.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
