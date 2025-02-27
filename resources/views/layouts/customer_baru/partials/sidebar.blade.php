@php
    function setActive($route)
    {
        return request()->routeIs($route) ? 'active' : '';
    }
@endphp

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="" class="b-brand text-primary">
                <img src="{{ asset('asset/images/logo-inet.png') }}" class="img-fluid logo-lg" alt="logo"
                    style="width: 50px;">
                <span class="badge bg-light-danger rounded-pill ms-2 theme-version">IndonesiaNet</span>
            </a>
        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('asset/images/user/avatar-1.jpg') }}" alt="user-image"
                            class="user-avtar wid-45 rounded-circle" />
                    </div>
                    <div class="flex-grow-1 ms-3 me-2">
                        <h6 class="mb-0">
                            @auth
                                {{ Auth::user()->name }}
                            @endauth
                        </h6>
                        <small>
                            @auth
                                {{ Auth::user()->email }}
                            @endauth
                        </small>
                    </div>
                    <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse"
                        href="#pc_sidebar_userlink">
                        <svg class="pc-icon">
                            <use xlink:href="#custom-sort-outline"></use>
                        </svg>
                    </a>
                </div>
                <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                    <div class="pt-3">
                        <a href="{{ route('customer.profile.edit') }}">
                            <i class="ti ti-user"></i>
                            <span>My Account</span>
                        </a>
                        {{-- <a href="#!">
                            <i class="ti ti-settings"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#!">
                            <i class="ti ti-lock"></i>
                            <span>Lock Screen</span>
                        </a> --}}
                        <a href="#" id="logoutBtn">
                            <i class="ti ti-power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-caption">
                    <span>Dashboard</span>
                </li>
                <li class="pc-item {{ setActive('customer.dashboard') }}">
                    <a href="{{ route('customer.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                {{-- <li class="pc-caption">
                    <span>Schedules & Reports</span>
                </li>
                <li class="pc-item {{ setActive('admin.complaint.schedule-index') }}">
                    <a href="{{ route('admin.complaint.schedule-index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar"></i></span>
                        <span class="pc-mtext">Schedule Today</span>
                    </a>
                </li>
                <li class="pc-item {{ setActive('admin.complaint.index') }}">
                    <a href="{{ route('admin.complaint.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-alert-circle"></i></span>
                        <span class="pc-mtext">Complaints</span>
                    </a>
                </li>

                <li class="pc-caption">
                    <span>Management</span>
                </li>
                <li class="pc-item {{ setActive('admin.customer.index') }}">
                    <a href="{{ route('admin.customer.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Customers</span>
                    </a>
                </li>
                <li class="pc-item {{ setActive('admin.technician.index') }}">
                    <a href="{{ route('admin.technician.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-tools"></i></span>
                        <span class="pc-mtext">Technicians</span>
                    </a>
                </li> --}}
                {{-- 
                <li class="pc-caption">
                    <span>Settings</span>
                </li>
                <li class="pc-item">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-adjustments"></i></span>
                        <span class="pc-mtext">Settings</span>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>

<!-- Form Logout (Tersembunyi) -->
<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- SweetAlert -->
<script>
    document.getElementById("logoutBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah link dari berpindah halaman

        Swal.fire({
            title: "Konfirmasi Logout",
            text: "Apakah Anda yakin ingin keluar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Logout",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("logoutForm").submit();
            }
        });
    });
</script>
