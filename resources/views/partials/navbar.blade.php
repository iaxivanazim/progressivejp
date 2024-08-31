<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Laravel</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissions.index') }}">Permissions</a>
                </li>
                <li class="nav-item">
                    {{-- <a class="nav-link" href="{{ route('users.index') }}">Users</a> --}}
                </li>
            @endauth
        </ul>
    </div>
</nav>