<!doctype html>
<html lang="en">
  @include('admin.partials.header')

  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav ms-auto">
            <li class="user-footer">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-default btn-flat float-end" type="submit">Sign out</button>
              </form>
            </li>
          </ul>
        </div>
      </nav>

      @include('admin.partials.sidebar')

      <main class="app-main">
        <div class="container-fluid">
          @yield('content')
        </div>
      </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  </body>
</html>
