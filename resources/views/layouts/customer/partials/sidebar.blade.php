<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('customer.dashboard') }}" class="logo">
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
                <li class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('customer.dashboard') }}" class="collapsed" aria-expanded="false">
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
                <li class="nav-item {{ request()->routeIs('customer.create.complaint') ? 'active' : '' }}">
                    <a href="{{ route('customer.create.complaint') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Complaint</p>
                    </a>
                </li>

                <!-- Menu History Complaint -->
                <li class="nav-item {{ request()->routeIs('customer.history.complaint') ? 'active' : '' }}">
                    <a href="{{ route('customer.history.complaint') }}">
                        <i class="fas fa-history"></i>
                        <p>History Complaint</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
