<aside class="sidebar">
  <div class="brand">{{ config('app.name') }}</div>
  <nav class="nav">
  <a href="{{ route('dashboard', ['tab' => 'banks']) }}" class="{{ ($tab ?? '') === 'banks' ? 'active' : '' }}">
    Banks <span class="count">{{ $counts['banks'] ?? '' }}</span>
  </a>
  <a href="{{ route('dashboard', ['tab' => 'currencies']) }}" class="{{ ($tab ?? '') === 'currencies' ? 'active' : '' }}">
    Currencies <span class="count">{{ $counts['currencies'] ?? '' }}</span>
  </a>
  <!-- <a href="{{ route('dashboard', ['tab' => 'merchants']) }}" class="{{ ($tab ?? '') === 'merchants' ? 'active' : '' }}">
      Merchants <span class="count">{{ $counts['merchants'] ?? '' }}</span>
  </a>
  <a href="{{ route('dashboard', ['tab' => 'transactions']) }}" class="{{ ($tab ?? '') === 'transactions' ? 'active' : '' }}">
      Transactions <span class="count">{{ $counts['transactions'] ?? '' }}</span>
  </a>
  <a href="{{ route('dashboard', ['tab' => 'pos']) }}" class="{{ ($tab ?? '') === 'pos' ? 'active' : '' }}">
      POS <span class="count">{{ $counts['pos'] ?? '' }}</span>
  </a> -->
 
  </nav>
</aside>
 