@php
    function setActive($route)
    {
        return request()->routeIs($route) ? 'active' : '';
    }
@endphp

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <!-- LOGO -->
        <div class="m-header">
            <a href="{{ route('technician.dashboard') }}" class="b-brand text-primary">
                <img src="{{ asset('asset/images/logo-inet.png') }}" class="img-fluid logo-lg" alt="logo"
                    style="width: 50px;">
                <span class="badge bg-light-danger rounded-pill ms-2 theme-version">IndonesiaNet</span>
            </a>
        </div>

        <!-- USER INFO -->
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
                        <a href="{{ route('technician.profile.edit') }}">
                            <i class="ti ti-user"></i>
                            <span>My Account</span>
                        </a>
                        <a href="#" id="logoutBtn">
                            <i class="ti ti-power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- NAVIGATION MENU -->
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-caption">
                    <span>Dashboard</span>
                </li>
                <li class="pc-item {{ setActive('technician.dashboard') }}">
                    <a href="{{ route('technician.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <!-- COMPLAINTS & SCHEDULES -->
                <li class="pc-caption">
                    <span>Technician Panel</span>
                </li>
                <li class="pc-item {{ setActive('technician.complaints') }}">
                    <a href="{{ route('technician.complaints') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-alert-circle"></i></span>
                        <span class="pc-mtext">Complaints</span>
                    </a>
                </li>
                <li class="pc-item {{ setActive('technician.schedule') }}">
                    <a href="{{ route('technician.schedule') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar"></i></span>
                        <span class="pc-mtext">Schedule Today</span>
                    </a>
                </li>
                <li class="pc-item {{ setActive('technician.history') }}">
                    <a href="{{ route('technician.history') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-history"></i></span>
                        <span class="pc-mtext">History</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- FORM LOGOUT TERSEMBUNYI -->
<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- SWEETALERT LOGOUT -->
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
