@extends('layouts.admin.master')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Admin Dashboard</h3>
                <h6 class="op-7 mb-2">Welcome, {{ auth()->user()->name }}! Here’s a comprehensive overview of your admin
                    activities.</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Users</p>
                                    <h4 class="card-title">{{ $usersCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Technicians</p>
                                    <h4 class="card-title">{{ $techniciansCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Complaints</p>
                                    <h4 class="card-title">{{ $complaintsCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Customers</p>
                                    <h4 class="card-title">{{ $customersCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Customer Complaint Statistics</div>
                            <div class="card-tools">
                                <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                    <span class="btn-label"><i class="fa fa-pencil"></i></span>
                                    Export
                                </a>
                                <a href="#" class="btn btn-label-info btn-round btn-sm">
                                    <span class="btn-label"><i class="fa fa-print"></i></span>
                                    Print
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                            <canvas id="statisticsChartCustomer"></canvas>
                        </div>
                        <div id="myChartLegend"></div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Get the context of the chart
                    var ctx = document.getElementById('statisticsChartCustomer').getContext('2d');

                    // Data passed from the controller
                    var complaintsByCategory = @json($complaintsByCategory);

                    // Add year to month labels (e.g., Jan 2025, Feb 2025, etc.)
                    var year = new Date().getFullYear();
                    var labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"].map(
                        function(month) {
                            return month + ' ' + year;
                        });

                    // Generate datasets for complaints by category
                    var datasets = complaintsByCategory.map(function(item) {
                        return {
                            label: item.category, // Category name (e.g., Gangguan, Instalasi, Tagihan)
                            borderColor: getCategoryColor(item.category), // Border color
                            pointBackgroundColor: getCategoryColor(item.category, 0.6), // Point color
                            pointRadius: 0, // No points
                            backgroundColor: getCategoryColor(item.category, 0.4), // Background color with opacity
                            legendColor: getCategoryColor(item.category), // Legend color
                            fill: true, // Fill the area under the line
                            borderWidth: 2, // Line thickness
                            data: item.data // Data points for the months
                        };
                    });

                    // Create the chart using Chart.js
                    var statisticsChartCustomer = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: false // Hide default legend
                            },
                            tooltips: {
                                bodySpacing: 4,
                                mode: "nearest",
                                intersect: 0,
                                position: "nearest",
                                xPadding: 10,
                                yPadding: 10,
                                caretPadding: 10
                            },
                            layout: {
                                padding: {
                                    left: 5,
                                    right: 5,
                                    top: 15,
                                    bottom: 15
                                }
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        fontStyle: "500",
                                        beginAtZero: false,
                                        maxTicksLimit: 5,
                                        padding: 10
                                    },
                                    gridLines: {
                                        drawTicks: false,
                                        display: false
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        zeroLineColor: "transparent"
                                    },
                                    ticks: {
                                        padding: 10,
                                        fontStyle: "500"
                                    }
                                }]
                            },
                            legendCallback: function(chart) {
                                var text = [];
                                text.push('<ul class="' + chart.id + '-legend html-legend">');
                                for (var i = 0; i < chart.data.datasets.length; i++) {
                                    text.push('<li><span style="background-color:' + chart.data.datasets[i]
                                        .legendColor + '"></span>');
                                    if (chart.data.datasets[i].label) {
                                        text.push(chart.data.datasets[i].label);
                                    }
                                    text.push('</li>');
                                }
                                text.push('</ul>');
                                return text.join('');
                            }
                        }
                    });

                    // Append the custom legend to the chart container
                    var myLegendContainer = document.getElementById("myChartLegend");
                    myLegendContainer.innerHTML = statisticsChartCustomer.generateLegend();

                    // Attach click event to legend items to toggle dataset visibility
                    var legendItems = myLegendContainer.getElementsByTagName('li');
                    for (var i = 0; i < legendItems.length; i++) {
                        legendItems[i].addEventListener("click", legendClickCallback, false);
                    }

                    // Toggle dataset visibility on legend click
                    function legendClickCallback(event) {
                        var index = Array.prototype.indexOf.call(legendItems, event.target.parentNode);
                        var meta = statisticsChartCustomer.getDatasetMeta(index);
                        meta.hidden = !meta.hidden;
                        statisticsChartCustomer.update();

                        // Add a strike-through effect when the dataset is hidden
                        if (meta.hidden) {
                            event.target.style.textDecoration = 'line-through';
                        } else {
                            event.target.style.textDecoration = 'none';
                        }
                    }
                });

                // Function to get color based on category with optional opacity
                function getCategoryColor(category, opacity = 1) {
                    var colorMap = {
                        'Gangguan': 'rgba(243, 84, 93', // Red
                        'Instalasi': 'rgba(0, 123, 255', // Blue
                        'Tagihan': 'rgba(40, 167, 69', // Green
                    };

                    return colorMap[category] ? colorMap[category] + ',' + opacity + ')' : 'rgba(0,0,0,0.2)';
                }
            </script>



            <div class="col-md-4">
                <!-- Recent Complaints Card -->
                <div class="card card-primary card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Recent Complaints</div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="list-group">
                            @foreach ($recentComplaints as $complaint)
                                <a href="#"
                                    class="list-group-item d-flex justify-content-between align-items-center mb-3">
                                    <!-- Menambahkan mb-3 untuk jarak -->
                                    <div>
                                        <p class="mb-0 font-weight-bold">{{ $complaint->customer->name }}</p>
                                        <small class="text-muted">{{ $complaint->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span
                                        class="badge badge-{{ $complaint->status == 'completed' ? 'success' : ($complaint->status == 'pending' ? 'warning' : 'info') }}">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
