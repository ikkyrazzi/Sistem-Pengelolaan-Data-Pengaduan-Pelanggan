<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('technician.dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/logo-inet.png') }}" alt="navbar brand" class="navbar-brand"
                    height="40" />
                <span style="color: white; margin-left: 10px;">IndonesiaNet</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <!-- Menu Dashboard -->
                <li class="nav-item {{ request()->routeIs('technician.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('technician.dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Section Pages -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Pages</h4>
                </li>

                <!-- Menu Complaint -->
                <li class="nav-item {{ request()->routeIs('technician.complaints') ? 'active' : '' }}">
                    <a href="{{ route('technician.complaints') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Complaint</p>
                    </a>
                </li>

                <!-- Menu Scheduled Complaints -->
                <li class="nav-item {{ request()->routeIs('technician.schedule') ? 'active' : '' }}">
                    <a href="{{ route('technician.schedule') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Schedule Complaint</p>
                    </a>
                </li>

                <!-- Menu History -->
                <li class="nav-item {{ request()->routeIs('technician.history') ? 'active' : '' }}">
                    <a href="{{ route('technician.history') }}">
                        <i class="fas fa-history"></i>
                        <p>History Complaint</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
