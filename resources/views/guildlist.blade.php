@section('title', __('Guild List'))
@section('description', __('Show all the guilds you are on, with counters, permissions, features, experiments and more information about the guilds.'))
@section('keywords', '')
@section('robots', 'index, follow')

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
                            <h5>{!! __('This website is open source on :github.', ['github' => '<a href="' . env('GITHUB_URL') . '" target="_blank">GitHub</a>']) !!}</h5>
                            <a role="button" class="btn btn-info mt-3" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                        </div>
                    @endguest
                    @auth
                        <div class="card-header text-center">
                            <h1 class="fw-bold">{!! __('You are in <span class="text-primary">:GUILDS</span> Servers', ['guilds' => $countGuilds]) !!}</h1>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('owner')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/owner.png') }}" class="discord-badge" alt="owner badge"> {{ __('You own') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countOwner }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countOwner, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('administrator')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/administrator.png') }}" class="discord-badge" alt="administrator badge"> {{ __('You administrate') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countAdministrator }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countAdministrator, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('moderator')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/moderator.png') }}" class="discord-badge" alt="moderator badge"> {{ __('You moderate') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countModerator }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countModerator, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('verified')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="verified badge"> {{ __('Verified') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countVerified }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countVerified, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('partnered')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="partnered badge"> {{ __('Partnered') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countPartnered }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countPartnered, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('vanityurl')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/vanity-url.svg') }}" class="discord-badge" alt="vanity url badge"> {{ __('Vanity URL') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countVanityUrl }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countVanityUrl, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('community')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/community.svg') }}" class="discord-badge" alt="community badge"> {{ __('Community enabled') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countCommunityEnabled }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countCommunityEnabled, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('discovery')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/discovery.png') }}" class="discord-badge" alt="discovery badge"> {{ __('Discovery enabled') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countDiscoveryEnabled }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countDiscoveryEnabled, $countGuilds, 1) }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div wire:click="changeCategory('welcomescreen')" class="card text-white bg-cards-grey text-center cursor-pointer mb-3">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/welcome-screen-enabled.svg') }}" class="discord-badge" alt="welcome screen badge"> {{ __('Welcome Screen enabled') }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title">{{ $countWelcomeScreenEnabled }}</h1>
                                            <hr>
                                            <h4 class="card-title">{{ calcPercent($countWelcomeScreenEnabled, $countGuilds, 1) }}%</h4>
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
                            <select wire:model="sorting" class="form-select">
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
                                @if(empty($this->guildsJsonSearch))
                                    <div>
                                        {{ __('No Guild found.') }}
                                    </div>
                                @endif
                                @foreach($this->guildsJsonSearch as $guild)
                                    <div class="col-12 mt-1 mb-1">
                                        <div class="row">
                                            <div class="col-12 col-md-1 text-center">
                                                @if($guild['icon'])
                                                    <a href="https://cdn.discordapp.com/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}" target="_blank">
                                                        <img src="https://cdn.discordapp.com/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}?size=128" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                                    </a>
                                                @else
                                                    <img src="https://cdn.discordapp.com/embed/avatars/0.png" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-6 text-center text-md-start">
                                                <div>
                                                    {{ $guild['name'] }}
                                                    @if($guild['owner']) {!! getBadgeImageWithTooltip('owner', __('You own')) !!}
                                                    @elseif(hasAdministrator($guild['permissions'])) {!! getBadgeImageWithTooltip('administrator', __('You administrate')) !!}
                                                    @elseif(hasModerator($guild['permissions'])) {!! getBadgeImageWithTooltip('moderator', __('You moderate')) !!} @endif
                                                    @if(in_array('VERIFIED', $guild['features'])) {!! getBadgeImageWithTooltip('verified', __('Discord Verified')) !!} @endif
                                                    @if(in_array('PARTNERED', $guild['features'])) {!! getBadgeImageWithTooltip('partner', __('Discord Partner')) !!} @endif
                                                </div>
                                                <div class="mt-n1">
                                                    <small class="text-muted">
                                                        {{ $guild['id'] }} &bull; {{ date('Y-m-d', getTimestamp($guild['id']) / 1000) }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-5 text-center text-md-end">
                                                <a role="button" href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}" rel="nofollow" class="btn btn-sm btn-outline-primary mt-2 mt-xl-0">{{ __('Guild Info') }}</a>
                                                <button wire:click="$emitTo('modal.guild-features', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-success mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalFeatures">{{ __('Features') }}</button>
                                                <button wire:click="$emitTo('modal.guild-permissions', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')" class="btn btn-sm btn-outline-danger mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalPermissions">{{ __('Permissions') }}</button>
                                                <button wire:click="$emitTo('modal.guild-experiments', 'update', '{{ $guild['id'] }}', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-warning mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalExperiments">{{ __('Experiments') }}</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $(function () {
                $('[data-bs-toggle="tooltip"]').tooltip()
            })
            Livewire.hook('message.processed', (message, component) => {
                $(function () {
                    $('[data-bs-toggle="tooltip"]').tooltip()
                })
            })
        })
        window.addEventListener('scrollToSearch', () => document.getElementById('scrollToSearch').scrollIntoView(true))
    </script>

    @livewire('modal.guild-features')
    @livewire('modal.guild-permissions')
    @livewire('modal.guild-experiments')
</div>
