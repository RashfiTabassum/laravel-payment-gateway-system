<<<<<<< Updated upstream
<header>
  <div><strong>{{ config('app.name') }} Admin</strong></div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn" type="submit">Logout</button>
  </form>
</header>
=======
<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>@yield('title', 'Dashboard') | AdminLTE v4</title>

  {{-- Accessibility / primary meta --}}
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
  <meta name="title" content="AdminLTE v4 | Dashboard" />
  <meta name="author" content="ColorlibHQ" />
  <meta
    name="description"
    content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
  />
  <meta
    name="keywords"
    content="bootstrap 5, bootstrap, admin dashboard, charts, tables, colorlibhq, accessible, WCAG"
  />
  <meta name="supported-color-schemes" content="light dark" />

  {{-- Preload AdminLTE CSS from /public/css (important: use asset()) --}}
  <link rel="preload" href="{{ asset('css/adminlte.min.css') }}" as="style" />

  {{-- Fonts --}}
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    crossorigin="anonymous"
    media="print"
    onload="this.media='all'"
  />

  {{-- Third-party CSS --}}
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    crossorigin="anonymous"
  />
  {{-- Charts/Maps CSS--}}
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
    crossorigin="anonymous"
  />

  {{-- AdminLTE CSS from public/css  --}}
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  {{-- If you prefer non-minified, swap to:  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}"> --}}

  {{-- Page-specific styles --}}
  @stack('styles')
</head>
>>>>>>> Stashed changes
