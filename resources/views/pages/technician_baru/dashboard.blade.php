@extends('layouts.technician_baru.master')

@section('title', 'Dashboard Technician')

@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Dashboard</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Total Complaints -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-primary">
                                <i class="ti ti-list text-primary" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Complaints Today</h6>
                            <h4 class="mb-0">{{ $totalComplaintsToday }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- In Progress Complaints -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-warning">
                                <i class="ti ti-loader text-warning" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">In Progress</h6>
                            <h4 class="mb-0">{{ $inProgressToday }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resolved Complaints -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-success">
                                <i class="ti ti-check text-success" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Resolved</h6>
                            <h4 class="mb-0">{{ $resolvedToday }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Complaints -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-danger">
                                <i class="ti ti-alert-circle text-danger" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Pending</h6>
                            <h4 class="mb-0">{{ $pendingToday }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- [ Schedule Today Table ] start -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Schedule Today</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="complaintsTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Customer</th>
                                        <th>Schedule Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentComplaints as $index => $complaint)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $complaint->subject }}</td>
                                            <td>{{ $complaint->customer->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($complaint->schedule)->format('d-m-Y H:i:s') }}
                                            </td>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $complaint->status == 'completed' ? 'success' : ($complaint->status == 'in_progress' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($complaint->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($recentComplaints->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">No complaints scheduled for today.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Troubleshooting Tips</div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Periksa kabel jaringan dan pastikan semua konektor terpasang dengan baik.</li>
                            <li>Restart modem dan router dengan mencabut daya selama 10-30 detik, lalu nyalakan kembali.
                            </li>
                            <li>Gunakan perintah <code>ping</code> untuk mengecek konektivitas ke server atau gateway.</li>
                            <li>Periksa apakah ada gangguan jaringan di area pelanggan dengan mengecek sistem monitoring.
                            </li>
                            <li>Pastikan konfigurasi IP, subnet mask, dan gateway sesuai dengan pengaturan jaringan.</li>
                            <li>Gunakan perintah <code>tracert</code> atau <code>traceroute</code> untuk menganalisis jalur
                                koneksi.</li>
                            <li>Jika ada interferensi WiFi, ubah kanal frekuensi pada pengaturan router.</li>
                            <li>Periksa status perangkat di dashboard monitoring dan lakukan remote troubleshoot jika
                                memungkinkan.</li>
                            <li>Jika kendala berlanjut, lakukan reset perangkat ke pengaturan pabrik dan konfigurasi ulang.
                            </li>
                            <li>Catat hasil troubleshooting dan eskalasi ke tim support jika diperlukan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Schedule Today Table ] end -->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#complaintsTable').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
@endpush
