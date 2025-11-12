<header>
  <div><strong>{{ config('app.name') }} Admin</strong></div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn" type="submit">Logout</button>
  </form>
</header>

<head>
<meta charset="utf-8" />
<title>@yield('title', 'AdminLTE v4 | Dashboard')</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="color-scheme" content="light dark" />
 
  {{-- Fonts (optional) --}}
<link rel="preload" href="{{ asset('css/adminlte.css') }}" as="style" />
 
  {{-- Bootstrap Icons (optional, used by your sidebar) --}}
<link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
 
  {{-- OverlayScrollbars (optional) --}}
<link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
 
  {{-- AdminLTE CSS from /public/css --}}
<link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  {{-- or use the non-minified one if that’s what you have:
<link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
  --}}
 
  {{-- Page-specific styles --}}
  @stack('styles')
</head>
>>>>>>> 00f5bdf (merchant crud)
