<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto">
            <li class="user-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-primary btn-flat float-end" type="submit">Sign out</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
