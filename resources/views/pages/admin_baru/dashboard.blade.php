@extends('layouts.admin_baru.master')

@section('title', 'Dashboard Admin')

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
            <!-- Total Users -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-primary">
                                <i class="ti ti-user text-primary" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Users</h6>
                            <h4 class="mb-0">{{ $usersCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Technicians -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-warning">
                                <i class="ti ti-tools text-warning" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Technicians</h6>
                            <h4 class="mb-0">{{ $techniciansCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Complaints Today -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-danger">
                                <i class="ti ti-alert-circle text-danger" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Complaints (Today)</h6>
                            <h4 class="mb-0">{{ $complaintsCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-success">
                                <i class="ti ti-users text-success" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Customers</h6>
                            <h4 class="mb-0">{{ $customersCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- [ Charts + Recent ] -->
        <div class="row">
            <div class="col-md-8">
                <div class="card" style="height: 420px;"> <!-- NEW: fixed height for better render -->
                    <div class="card-header">
                        <h5>Complaints by Category (Monthly) • {{ $currentYear }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" style="height: 320px;"></canvas> <!-- NEW: canvas height -->
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Complaint</h5>
                    </div>
                    <div class="card-body">
                        @if ($recentComplaints->isEmpty())
                            <p class="text-muted">No recent complaints.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($recentComplaints as $complaint)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $complaint->subject }}</strong><br>
                                            <small class="text-muted">
                                                by {{ $complaint->customer->name ?? 'Unknown' }} -
                                                {{ $complaint->customer->customerDetail->no_customer ?? 'Unknown' }}
                                            </small><br>
                                            <small class="text-muted">{{ $complaint->created_at->format('d M Y') }}</small>
                                        </div>
                                        <span
                                            class="badge bg-{{ $complaint->status == 'Resolved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($complaint->status) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('categoryChart').getContext('2d');

            // Tambahkan warna untuk Perangkat Rusak + fallback jika ada kategori baru lagi
            const categoryColors = {
                'Gangguan Internet': '#36a2eb',
                'Administrasi': '#ffcd56',
                'Perangkat Rusak': '#ff6384', // NEW
            };
            const fallbackColors = ['#4bc0c0', '#9966ff', '#c9cbcf', '#8dd17e', '#e17cfd', '#ffa600'];

            const datasets = [];
            let colorIdx = 0;

            @foreach ($complaintsByCategory as $categoryData)
                (function() {
                    const label = @json($categoryData['category']);
                    const data = @json($categoryData['data']);
                    const color = categoryColors[label] || fallbackColors[colorIdx++ % fallbackColors
                        .length]; // NEW: fallback

                    datasets.push({
                        label: label,
                        data: data,
                        borderColor: color,
                        backgroundColor: 'rgba(0,0,0,0)',
                        pointBorderColor: color,
                        pointBackgroundColor: color,
                        borderWidth: 2,
                        tension: 0.3
                    });
                })();
            @endforeach

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json(range(1, 12)), // Bulan 1-12
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Complaints'
                            },
                            ticks: {
                                precision: 0
                            } // bilangan bulat
                        }
                    }
                }
            });
        });
    </script>
@endpush
