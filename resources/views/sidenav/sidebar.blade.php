<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ProgressiveJP</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        {{-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div> --}}
        @auth
            @if (auth()->user()->hasPermission('profile_create'))
                <a class="nav-link collapsed" href="{{ route('register') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Register New User</span>
                </a>
            @endif
        @endauth
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('role_view'))
                <a class="nav-link collapsed" href="{{route('roles.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Define Roles</span>
                </a>
            @endif
        @endauth
        {{-- <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div> --}}
    </li>

    <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('users_view'))
                <a class="nav-link collapsed" href="{{route('users.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Define Users</span>
                </a>
            @endif
        @endauth
        {{-- <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div> --}}
    </li>

    <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('game_tables_view'))
                <a class="nav-link collapsed" href="{{route('game_tables.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Define Game Tables</span>
                </a>
            @endif
        @endauth
        {{-- <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div> --}}
    </li>

    <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('jackpots_view'))
                <a class="nav-link collapsed" href="{{route('jackpots.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Define Jackpots</span>
                </a>
            @endif
        @endauth
        {{-- <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div> --}}
    </li>

    {{-- <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('bets_view'))
                <a class="nav-link collapsed" href="{{route('bets.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Define bets</span>
                </a>
            @endif
        @endauth
        
    </li> --}}

    <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('house_commissions_view'))
                <a class="nav-link collapsed" href="{{route('house_commissions.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>House Commissions</span>
                </a>
            @endif
        @endauth
        {{-- <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div> --}}
    </li>

    <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('hands_view'))
                <a class="nav-link collapsed" href="{{route('hands.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Configure hands</span>
                </a>
            @endif
        @endauth
        {{-- <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div> --}}
    </li>

    <li class="nav-item">
        @auth
            @if (auth()->user()->hasPermission('jackpot_winners_view'))
                <a class="nav-link collapsed" href="{{route('jackpot_winners.index')}}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Jackpot Wins</span>
                </a>
            @endif
        @endauth
        {{-- <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div> --}}
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
