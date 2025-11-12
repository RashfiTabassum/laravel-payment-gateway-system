<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <span class="brand-text fw-light">PayGate</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="navigation"
          aria-label="Main navigation"
          data-accordion="false"
          id="navigation">

        {{-- Dashboard --}}
        <li class="nav-item">
          <a href="{{ route('dashboard') }}"
             class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>

        {{-- Banks --}}
        <li class="nav-item">
          <a href="{{ route('banks.index') }}"
            class="nav-link {{ request()->routeIs('banks.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-bank"></i>
            <p>Banks</p>
          </a>

        </li>
        

        {{-- Currencies (add the route when you create it) --}}
        {{-- <li class="nav-item">
          <a href="{{ route('currencies.index') }}"
             class="nav-link {{ request()->routeIs('currencies.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-cash-coin"></i>
            <p>Currencies</p>
          </a>
        </li> --}}

        {{-- Merchants --}}
        {{-- <li class="nav-item">
          <a href="{{ route('merchants.index') }}"
             class="nav-link {{ request()->routeIs('merchants.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people"></i>
            <p>Merchants</p>
          </a>
        </li> --}}

        {{-- Admins --}}
        {{-- <li class="nav-item">
          <a href="{{ route('admins.index') }}"
             class="nav-link {{ request()->routeIs('admins.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-shield-lock"></i>
            <p>Admins</p>
          </a>
        </li> --}}

        {{-- Transactions --}}
        {{-- <li class="nav-item">
          <a href="{{ route('transactions.index') }}"
             class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-receipt"></i>
            <p>Transactions</p>
          </a>
        </li> --}}

        {{-- POS --}}
        {{-- <li class="nav-item">
          <a href="{{ route('pos.index') }}"
             class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-pc-display"></i>
            <p>POS</p>
          </a>
        </li> --}}

      </ul>
    </nav>
  </div>
</aside>
