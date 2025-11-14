<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">PayGate</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" id="navigation">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admins.index') }}"
                       class="nav-link {{ request()->routeIs('admins.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('merchants.index') }}"
                       class="nav-link {{ request()->routeIs('merchants.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Merchants</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('banks.index') }}"
                       class="nav-link {{ request()->routeIs('banks.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bank"></i>
                        <p>Banks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('currencies.index') }}"
                       class="nav-link {{ request()->routeIs('currencies.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>Currencies</p>
                    </a>
                </li>
              <li class="nav-item">
                    <a href="{{ route('pos.index') }}"
                       class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-credit-card"></i>
                        <p>Pos</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
