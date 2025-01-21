<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo">
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
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed" aria-expanded="false">
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

                <!-- Menu Schedule Technician -->
                <li class="nav-item {{ request()->routeIs('admin.complaint.schedule-index') ? 'active' : '' }}">
                    <a href="{{ route('admin.complaint.schedule-index') }}">
                        <i class="fas fa-calendar-check"></i>
                        <p>Schedule Technician</p>
                    </a>
                </li>

                <!-- Menu Complaints -->
                <li class="nav-item {{ request()->routeIs('admin.complaint.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.complaint.index') }}">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Complaints</p>
                    </a>
                </li>

                <!-- Menu Customers -->
                <li class="nav-item {{ request()->routeIs('admin.customer.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.customer.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>

                <!-- Menu Technicians -->
                <li class="nav-item {{ request()->routeIs('admin.technician.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.technician.index') }}">
                        <i class="fas fa-wrench"></i>
                        <p>Technicians</p>
                    </a>
                </li>

                <!-- Menu Manage Users -->
                <li class="nav-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.index') }}">
                        <i class="fas fa-user-cog"></i>
                        <p>Manage Users</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
