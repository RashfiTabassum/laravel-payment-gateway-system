<aside class="app-sidebar bg-body-secondary shadow">
    <div class="sidebar-brand">
        <a href="{{ route('merchant.dashboard') }}" class="brand-link">PayGate</a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column">
                <li class="nav-item">
                    <a href="{{ route('merchant.dashboard') }}" class="nav-link {{ request()->routeIs('merchant.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('merchant.profile') }}" class="nav-link {{ request()->routeIs('merchant.profile') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person"></i>
                        <p>My Info</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
