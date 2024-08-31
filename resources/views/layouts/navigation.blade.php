<nav class="navbar navbar-expand-lg navbar-light bg-white bg-dark border-bottom border-light">
    <!-- Primary Navigation Menu -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex">
                <!-- Logo -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="h-9 w-auto text-dark" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="d-none d-lg-flex ms-4">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="d-none d-lg-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light bg-dark text-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Authentication -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="d-lg-none">
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    {{ __('Dashboard') }}
                </a>
            </li>
        </ul>

        <!-- Responsive Settings Options -->
        <hr class="d-lg-none text-light">
        <ul class="navbar-nav d-lg-none">
            <li class="nav-item">
                <span class="nav-link">{{ Auth::user()->name }}</span>
            </li>
            <li class="nav-item">
                <span class="nav-link">{{ Auth::user()->username }}</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
            </li>
            <!-- Authentication -->
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-link btn btn-link" type="submit">{{ __('Log Out') }}</button>
                </form>
            </li>
        </ul>
    </div>
</nav>