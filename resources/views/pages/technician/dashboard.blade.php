@extends('layouts.technician.master')

@section('title', 'Technician Dashboard')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard Technician</h3>
                <p class="text-muted">Welcome back, {{ auth()->user()->name }}! Stay on top of your tasks and activities with
                    a quick overview of your ongoing complaints, schedules, and history.</p>
            </div>
        </div>

        <!-- Statistik Keluhan -->
        <div class="row">
            <!-- Keluhan yang sedang diproses -->
            <div class="col-sm-6 col-md-4">
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

            <!-- Keluhan yang telah diselesaikan -->
            <div class="col-sm-6 col-md-4">
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

            <!-- Keluhan yang sedang menunggu -->
            <div class="col-sm-6 col-md-4">
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

        <!-- Daftar Keluhan Terbaru -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Schedule Today</div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($recentComplaints->isEmpty())
                            <p class="text-muted">No Schedule Today found.</p>
                        @else
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Schedule</th>
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
                                            <td>{{ $complaint->schedule }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tips & Troubleshooting -->
            <div class="col-md-4">
                <div class="card card-primary card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Troubleshooting Tips</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Selalu bawa alat kerja standar seperti crimping tool, kabel UTP, dan tester kabel.</li>
                            <li>Periksa kondisi modem dan router pelanggan sebelum memulai perbaikan.</li>
                            <li>Pastikan semua koneksi kabel (LAN/WAN) terpasang dengan benar dan tidak longgar.</li>
                            <li>Lakukan pengukuran kecepatan internet menggunakan alat uji resmi atau aplikasi yang
                                ditentukan.</li>
                            <li>Jika diperlukan, lakukan konfigurasi ulang pada perangkat pelanggan sesuai standar
                                perusahaan.</li>
                            <li>Jelaskan hasil perbaikan atau penyebab gangguan kepada pelanggan secara jelas dan mudah
                                dipahami.</li>
                            <li>Catat semua aktivitas perbaikan di aplikasi atau sistem laporan teknisi.</li>
                            <li>Laporkan segera jika menemukan masalah teknis yang memerlukan eskalasi ke tim support pusat.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
