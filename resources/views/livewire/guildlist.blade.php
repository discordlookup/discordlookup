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
                                    <div wire:click="changeCategory('owner')"
                                         class="card text-white bg-cards-grey text-center mb-3"
                                         style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/owner.png') }}" class="discord-badge" alt="owner badge"> {{ __('You own') }}
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
                                    <div wire:click="changeCategory('administrator')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/administrator.png') }}" class="discord-badge" alt="administrator badge"> {{ __('You administrate') }}
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
                                    <div wire:click="changeCategory('moderator')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/moderator.png') }}" class="discord-badge" alt="moderator badge"> {{ __('You moderate') }}
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
                                    <div wire:click="changeCategory('verified')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="verified badge"> {{ __('Verified') }}
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
                                    <div wire:click="changeCategory('partnered')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="partnered badge"> {{ __('Partnered') }}
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
                                    <div wire:click="changeCategory('vanityurl')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/vanity-url.svg') }}" class="discord-badge" alt="vanity url badge"> {{ __('Vanity URL') }}
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
                                    <div wire:click="changeCategory('community')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/community.svg') }}" class="discord-badge" alt="community badge"> {{ __('Community enabled') }}
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
                                    <div wire:click="changeCategory('discovery')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/discovery.png') }}" class="discord-badge" alt="discovery badge"> {{ __('Discovery enabled') }}
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
                                    <div wire:click="changeCategory('welcomescreen')" class="card text-white bg-cards-grey text-center mb-3" style="cursor: pointer;">
                                        <div class="card-header">
                                            <p class="card-text fw-bolder text-uppercase">
                                                <img src="{{ asset('images/discord/icons/server/welcome-screen-enabled.svg') }}" class="discord-badge" alt="welcome screen badge"> {{ __('Welcome Screen enabled') }}
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
                            @if(empty($this->guildsJsonSearch))
                                <div>
                                    {{ __('No Guild found.') }}
                                </div>
                            @endif
                            @foreach($this->guildsJsonSearch as $guild)
                                <div class="col-12 mt-1 mb-1">
                                    <livewire:guildlist-item key="{{ now() }}" :guild="$guild" />
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
            document.addEventListener("DOMContentLoaded", () => {
                $(function () {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                })

                Livewire.hook('message.processed', (message, component) => {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip()
                    })
                })
            });

            window.addEventListener('scrollToSearch', () => {
                document.getElementById('scrollToSearch').scrollIntoView(true);
            });
        </script>
    @endpush
</div>
