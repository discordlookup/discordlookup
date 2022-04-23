<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            {{--<img src="{{ asset('images/logo-rounded.svg') }}" height="64px" width="64px" alt="{{ env('APP_NAME') }} Logo">--}}
            <h1 class="text-primary fw-bolder">DiscordLookup</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>

                <li class="nav-item ms-lg-1 dropdown">
                    <a class="nav-link p-2 dropdown-toggle {{ (request()->routeIs('snowflake') || request()->routeIs('userlookup') || request()->routeIs('guildlookup') || request()->routeIs('applicationlookup') || request()->routeIs('snowflake-distance-calculator')) ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('Snowflake') }}
                    </a>
                    <ul class="dropdown-menu bg-dark border-0" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-white {{ request()->routeIs('snowflake') ? 'active' : '' }}" href="{{ route('snowflake') }}">{{ __('Snowflake Decoder') }}</a></li>
                        <li><a class="dropdown-item text-white {{ request()->routeIs('userlookup') ? 'active' : '' }}" href="{{ route('userlookup') }}">{{ __('User Lookup') }}</a></li>
                        <li><a class="dropdown-item text-white {{ request()->routeIs('guildlookup') ? 'active' : '' }}" href="{{ route('guildlookup') }}">{{ __('Guild Lookup') }}</a></li>
                        {{--<li><a class="dropdown-item text-white {{ request()->routeIs('applicationlookup') ? 'active' : '' }}" href="{{ route('applicationlookup') }}">{{ __('Application Lookup') }}</a></li>--}}
                        <li><a class="dropdown-item text-white {{ request()->routeIs('snowflake-distance-calculator') ? 'active' : '' }}" href="{{ route('snowflake-distance-calculator') }}">{{ __('Snowflake Distance Calculator') }}</a></li>
                    </ul>
                </li>

                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('guildlist') ? 'active' : '' }}" href="{{ route('guildlist') }}">{{ __('Guild List') }}</a>
                </li>

                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ (request()->routeIs('experiments') || request()->routeIs('experiment')) ? 'active' : '' }}" href="{{ route('experiments') }}">{{ __('Experiments') }}</a>
                </li>

                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('inviteresolver') ? 'active' : '' }}" href="{{ route('inviteresolver') }}">{{ __('Invite Resolver') }}</a>
                </li>

                <li class="nav-item ms-lg-1 dropdown">
                    <a class="nav-link p-2 dropdown-toggle {{ request()->routeIs('guild-shard-calculator') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('Advanced') }}
                    </a>
                    <ul class="dropdown-menu bg-dark border-0" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-white {{ request()->routeIs('guild-shard-calculator') ? 'active' : '' }}" href="{{ route('guild-shard-calculator') }}">{{ __('Guild Shard Calculator') }}</a></li>
                    </ul>
                </li>
                <li class="nav-item ms-lg-1">
                    <a class="nav-link p-2 {{ request()->routeIs('help') ? 'active' : '' }}" href="{{ route('help') }}">{{ __('Help') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-md-auto mt-3 mt-lg-0">
                <li class="nav-item me-0 d-none d-lg-block">
                    <a class="nav-link h5" href="{{ env('GITHUB_URL') }}" target="_blank"><i class="fab fa-github"></i></a>
                </li>
                <li class="nav-item mx-0 d-none d-lg-block">
                    <a class="nav-link h5" href="{{ env('DISCORD_URL') }}" target="_blank"><i class="fab fa-discord"></i></a>
                </li>
                @guest()
                    <li class="nav-item">
                        <a role="button" class="btn btn-info w-100" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                    </li>
                @endguest
                @auth()
                    <li class="nav-item dropdown">
                        <a role="button" class="btn btn-info w-100 dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <img src="{{ auth()->user()->avatarUrl }}" height="16px" width="16px" class="mr-2 rounded" alt="user image">
                            {{ auth()->user()->username }}
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
