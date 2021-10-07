<div id="guildlist">

    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Guild List') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="card text-white bg-dark border-0">

                    @guest
                        <div class="card-header text-center">
                            <h1 class="fw-bold">{{ __('Login') }}</h1>
                        </div>
                        <div class="card-body text-center">
                            <h4>{{ __('To get an overview and stats about your guilds you need to log in with Discord.') }}</h4>
                            <a role="button" class="btn btn-info mt-3" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                        </div>
                    @endguest
                    @auth
                        <div class="card-header text-center">
                            <h1 class="fw-bold">You are in <span class="text-primary">{{ $countGuilds }}</span> Servers</h1>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('owner')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/owner.png') }}" class="discord-badge" alt="owner badge"> {{ __('YOU OWN') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countOwner }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countOwner / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('administrator')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/administrator.png') }}" class="discord-badge" alt="administrator badge"> YOU ADMINISTRATE
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countAdministrator }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countAdministrator / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('moderator')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/moderator.png') }}" class="discord-badge" alt="moderator badge"> YOU MODERATE
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countModerator }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countModerator / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('verified')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="verified badge"> VERIFIED
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countVerified }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countVerified / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('partnered')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="partnered badge"> PARTNERED
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countPartnered }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countPartnered / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('vanityurl')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/vanity-url.svg') }}" class="discord-badge" alt="vanity url badge"> VANITY URL
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countVanityUrl }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countVanityUrl / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('community')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/community.svg') }}" class="discord-badge" alt="community badge"> COMMUNITY ENABLED
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countCommunityEnabled }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countCommunityEnabled / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('discovery')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/discovery.png') }}" class="discord-badge" alt="discovery badge"> DISCOVERY ENABLED
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countDiscoveryEnabled }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countDiscoveryEnabled / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('welcomescreen')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder">
                                                <img src="{{ asset('images/discord/icons/server/welcome-screen-enabled.svg') }}" class="discord-badge" alt="welcome screen badge"> WELCOME SCREEN ENABLED
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countWelcomeScreenEnabled }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ number_format($countWelcomeScreenEnabled / $countGuilds * 100, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small>
                                <a href="{{ route('help') }}#how-are-my-personal-stats-calculated-in-the-guild-list" target="_blank" class="text-muted text-decoration-none">
                                    <i class="far fa-question-circle"></i> <i>{{ __('How are my personal stats calculated on this page?') }}</i>
                                </a>
                            </small>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        @auth
        <div id="scrollToSearch" class="row mt-5">
            <div class="col-12 col-lg-10 offset-lg-1">

                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <select wire:model="category" class="form-select">
                            <option value="all" selected>{{ __('All Guilds') }}</option>
                            <option value="disabled" disabled></option>
                            <option value="owner">{{ __('You own') }}</option>
                            <option value="administrator">{{ __('You administrate') }}</option>
                            <option value="moderator">{{ __('You moderate') }}</option>
                            <option value="disabled" disabled></option>
                            <option value="verified">{{ __('Verified') }}</option>
                            <option value="partnered">{{ __('Partnered') }}</option>
                            <option value="vanityurl">{{ __('Vanity URL') }}</option>
                            <option value="disabled" disabled></option>
                            <option value="community">{{ __('Community enabled') }}</option>
                            <option value="discovery">{{ __('Discovery enabled') }}</option>
                            <option value="welcomescreen">{{ __('Welcome Screen enabled') }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mt-2 mt-md-0">
                        <input wire:model="search" type="text" class="form-control" placeholder="{{ __('Search...') }}">
                    </div>
                    <div class="col-12 col-md-3 mt-2 mt-md-0">
                        <select wire:model="order" class="form-select">
                            <option value="name-asc" selected>{{ __('Name Ascending') }}</option>
                            <option value="name-desc">{{ __('Name Descending') }}</option>
                            <option value="id-asc">{{ __('Created Ascending') }}</option>
                            <option value="id-desc">{{ __('Created Descending') }}</option>
                        </select>
                    </div>
                </div>

                <div class="card text-white bg-dark border-0">
                    <div class="card-body">
                        <div class="row">
                            @foreach($this->guildsJsonSearch as $guild)
                                <div class="col-12 mt-1 mb-1">
                                    <div class="row">
                                        <div class="col-auto">
                                            @if($guild['icon'])
                                                <img src="https://cdn.discordapp.com/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}?size=128" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                            @else
                                                <img src="https://cdn.discordapp.com/embed/avatars/0.png" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                            @endif
                                        </div>
                                        <div class="col-7">
                                            <div>
                                                {{ $guild['name'] }}

                                                @if($guild['owner'])
                                                    <img src="{{ asset('images/discord/icons/server/owner.png') }}" class="discord-badge" alt="owner badge">
                                                @elseif((($guild['permissions'] & (1 << 3)) == (1 << 3)))
                                                    <img src="{{ asset('images/discord/icons/server/administrator.png') }}" class="discord-badge">
                                                @elseif((
                                                    (($guild['permissions'] & (1 << 1)) == (1 << 1)) || // KICK_MEMBERS
                                                    (($guild['permissions'] & (1 << 2)) == (1 << 2)) || // BAN_MEMBERS
                                                    (($guild['permissions'] & (1 << 4)) == (1 << 4)) || // MANAGE_CHANNELS
                                                    (($guild['permissions'] & (1 << 5)) == (1 << 5)) || // MANAGE_GUILD
                                                    (($guild['permissions'] & (1 << 13)) == (1 << 13)) || // MANAGE_MESSAGES
                                                    (($guild['permissions'] & (1 << 27)) == (1 << 27)) || // MANAGE_NICKNAMES
                                                    (($guild['permissions'] & (1 << 28)) == (1 << 28)) || // MANAGE_ROLES
                                                    (($guild['permissions'] & (1 << 29)) == (1 << 29)) || // MANAGE_WEBHOOKS
                                                    (($guild['permissions'] & (1 << 34)) == (1 << 34)) // MANAGE_THREADS
                                                ))
                                                    <img src="{{ asset('images/discord/icons/server/moderator.png') }}" class="discord-badge" alt="moderator badge">
                                                @endif
                                                @if(in_array('VERIFIED', $guild['features']))
                                                    <img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="verified badge">
                                                @endif
                                                @if(in_array('PARTNERED', $guild['features']))
                                                    <img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="partner badge">
                                                @endif
                                            </div>
                                            <div class="mt-n1">
                                                <small class="text-muted">
                                                    {{ $guild['id'] }}
                                                    &bull;
                                                    {{ date('Y-m-d', (($guild['id'] >> 22) + 1420070400000) / 1000) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-auto ms-auto">
                                            <a role="button" class="btn btn-sm btn-outline-primary" href="{{ route('snowflake', ['snowflake' => $guild['id']]) }}">{{ __('Guild Info') }}</a>
                                            <button wire:click="$emitTo('guild-features-modal', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalFeatures">{{ __('Features') }}</button>
                                            <button wire:click="$emitTo('guild-permissions-modal', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalPermissions">{{ __('Permissions') }}</button>
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <hr>
                                    @endif
                                </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </div>

    @push('scripts')
        <script>
            window.addEventListener('scrollToSearch', () => {
                document.getElementById('scrollToSearch').scrollIntoView(true);
            });
        </script>
    @endpush
</div>
