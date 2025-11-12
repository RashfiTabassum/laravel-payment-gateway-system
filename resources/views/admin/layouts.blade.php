<!doctype html>
<html lang="en">
@include('admin.partials.header')

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
<div class="app-wrapper">
    @include('admin.partials.topbar')
    @include('admin.partials.sidebar')

    <main class="app-main">
        <div class="app-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </main>
    @include('admin.partials.footer')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/fontawesome.min.js"
        integrity="sha512-obFNtQ1JKCrxPBPLmYDUevlriATl5EhvwU3CFtdW/HKOkeAe0bbsyZfHO44/f1QyndrZJ464TQvrRP9ZjyXSSA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
