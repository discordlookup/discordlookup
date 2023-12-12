@section('title', __('Guild List'))
@section('description', __('Show all the guilds you are on, with counters, permissions, features, experiments and more information about the guilds.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Guild List') }}</h2>
    <div class="py-12 space-y-3">
        @guest
            <x-login-required />
        @endguest

        @auth
        <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
            <div class="py-4 px-5 lg:px-6 w-full text-center border-b border-discord-gray-4">
                <h3 class="text-4xl font-bold">
                    {!! __('You are in <span class="text-discord-blurple font-bold">:GUILDS</span> servers', ['guilds' => $countGuilds]) !!}
                </h3>
            </div>
            <div class="p-5 lg:p-6 grow w-full space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    <x-guildlist-category
                        category="owner"
                        :title="__('You own')"
                        :image="asset('images/discord/icons/server/owner.svg')"
                        :count="$countOwner"
                        :total="$countGuilds"
                    />
                    <x-guildlist-category
                        category="administrator"
                        :title="__('You administrate')"
                        :image="asset('images/discord/icons/server/administrator.svg')"
                        :count="$countAdministrator"
                        :total="$countGuilds"
                    />
                    <x-guildlist-category
                        category="moderator"
                        :title="__('You moderate')"
                        :image="asset('images/discord/icons/server/moderator.svg')"
                        :count="$countModerator"
                        :total="$countGuilds"
                    />

                    <x-guildlist-category
                        category="verified"
                        :title="__('Verified')"
                        :image="asset('images/discord/icons/server/verified.svg')"
                        :count="$countVerified"
                        :total="$countGuilds"
                    />
                    <x-guildlist-category
                        category="partnered"
                        :title="__('Partnered')"
                        :image="asset('images/discord/icons/server/partner.svg')"
                        :count="$countPartnered"
                        :total="$countGuilds"
                    />
                    <x-guildlist-category
                        category="vanityurl"
                        :title="__('Vanity URL')"
                        :image="asset('images/discord/icons/server/vanity-url.svg')"
                        :count="$countVanityUrl"
                        :total="$countGuilds"
                    />

                    <x-guildlist-category
                        category="community"
                        :title="__('Community enabled')"
                        :image="asset('images/discord/icons/server/community.svg')"
                        :count="$countCommunityEnabled"
                        :total="$countGuilds"
                    />
                    <x-guildlist-category
                        category="discovery"
                        :title="__('Discovery enabled')"
                        :image="asset('images/discord/icons/server/discovery.svg')"
                        :count="$countDiscoveryEnabled"
                        :total="$countGuilds"
                    />
                    <x-guildlist-category
                        category="welcomescreen"
                        :title="__('Welcome Screen enabled')"
                        :image="asset('images/discord/icons/server/welcome-screen-enabled.svg')"
                        :count="$countWelcomeScreenEnabled"
                        :total="$countGuilds"
                    />
                </div>
            </div>
        </div>
        @endauth
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
                                                    <a href="{{ env('DISCORD_CDN_URL') }}/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}" target="_blank">
                                                        <img src="{{ env('DISCORD_CDN_URL') }}/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}?size=128" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                                    </a>
                                                @else
                                                    <img src="{{ env('DISCORD_CDN_URL') }}/embed/avatars/0.png" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-6 text-center text-md-start">
                                                <div>
                                                    {{ $guild['name'] }}
                                                    @if($guild['owner']) {!! getDiscordBadgeServerIcons('owner', __('You own')) !!}
                                                    @elseif(hasAdministrator($guild['permissions'])) {!! getDiscordBadgeServerIcons('administrator', __('You administrate')) !!}
                                                    @elseif(hasModerator($guild['permissions'])) {!! getDiscordBadgeServerIcons('moderator', __('You moderate')) !!} @endif
                                                    @if(in_array('VERIFIED', $guild['features'])) {!! getDiscordBadgeServerIcons('verified', __('Discord Verified')) !!} @endif
                                                    @if(in_array('PARTNERED', $guild['features'])) {!! getDiscordBadgeServerIcons('partner', __('Discord Partner')) !!} @endif
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
