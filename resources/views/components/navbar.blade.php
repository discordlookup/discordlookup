<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            {{--<img src="{{ asset('images/logo-rounded.svg') }}" height="64px" width="64px" alt="{{ env('APP_NAME') }} Logo">--}}
            <h1 class="text-primary fw-bolder">DiscordLookup</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('snowflake') ? 'active' : '' }}" href="{{ route('snowflake') }}">{{ __('Snowflake') }}</a>
                </li>
                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('guildlist') ? 'active' : '' }}" href="{{ route('guildlist') }}">{{ __('Guild List') }}</a>
                </li>
                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('inviteinfo') ? 'active' : '' }}" href="{{ route('inviteinfo') }}">{{ __('Invite Info') }}</a>
                </li>
                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('help') ? 'active' : '' }}" href="{{ route('help') }}">{{ __('Help') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-md-auto mt-3 mt-lg-0">
                {{--<li class="nav-item">
                    <a class="nav-link h5"><i class="fas fa-sun"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link h5"><i class="fas fa-moon"></i></a>
                </li>--}}
                @guest()
                    <li class="nav-item">
                        <a role="button" class="btn btn-info w-100" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                    </li>
                @endguest
                @auth()
                    <li class="nav-item dropdown">
                        <a role="button" class="btn btn-info w-100 dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <img src="{{ auth()->user()->avatar }}" height="16px" width="16px" class="mr-2 rounded" alt="user image">
                            {{ auth()->user()->displayName }}
                        </a>
                        <div class="dropdown-menu bg-dark border-0">
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}">{{ __('Logout') }}</a>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
