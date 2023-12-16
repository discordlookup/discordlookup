@section('title', __('Guild List'))
@section('description', __('Show all the guilds you are on, with counters, permissions, features, experiments and more information about the guilds.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div x-data="{ modalExperimentsOpen: false, modalFeaturesOpen: false, modalPermissionsOpen: false }">
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Guild List') }}</h2>
    <div class="py-12">
        @guest
            <x-login-required />
        @endguest

        @auth
            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden mb-12">
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

            <div id="scrollToSearch" class="space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-x-3 gap-y-3 md:gap-y-0">
                    <x-input-prepend-icon icon="fas fa-server">
                        <select wire:model="category" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
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
                    </x-input-prepend-icon>

                    <x-input-prepend-icon icon="fas fa-search" class="col-span-2">
                        <input
                            wire:model="search"
                            type="text"
                            placeholder="{{ __('Search...') }}"
                            class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                        >
                    </x-input-prepend-icon>

                    <x-input-prepend-icon icon="fas fa-sort-alpha-down">
                        <select wire:model="sorting" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                            <option value="name-asc" selected>{{ __('Name Ascending') }}</option>
                            <option value="name-desc">{{ __('Name Descending') }}</option>
                            <option value="id-asc">{{ __('Created Ascending') }}</option>
                            <option value="id-desc">{{ __('Created Descending') }}</option>
                        </select>
                    </x-input-prepend-icon>
                </div>

                @if(empty($this->guildsJsonSearch))
                    <x-error-message>
                        {{ __('No guilds found.') }}
                    </x-error-message>
                @else
                    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                        <div class="grow p-5">
                            <div class="min-w-full overflow-x-auto">
                                <table class="min-w-full whitespace-nowrap align-middle text-sm">
                                    <tbody>
                                    @foreach($this->guildsJsonSearch as $guild)
                                        <tr class="{{ $loop->last ?: 'border-b border-discord-gray-4' }}">
                                            <td class="p-3 text-center">
                                                @if($guild['icon'])
                                                    <a href="{{ env('DISCORD_CDN_URL') }}/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}" target="_blank">
                                                        <img src="{{ env('DISCORD_CDN_URL') }}/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}?size=128" loading="lazy" class="inline-block h-12 w-12 rounded-full" alt="guild icon">
                                                    </a>
                                                @else
                                                    <img src="{{ env('DISCORD_CDN_URL') }}/embed/avatars/0.png" loading="lazy" class="inline-block h-12 w-12 rounded-full" alt="guild default icon">
                                                @endif
                                            </td>
                                            <td class="p-3">
                                                <p class="font-bold">
                                                    {{ cutString($guild['name'], 80) }}
                                                    @if($guild['owner']) {!! getDiscordBadgeServerIcons('owner', __('You own')) !!}
                                                    @elseif(hasAdministrator($guild['permissions'])) {!! getDiscordBadgeServerIcons('administrator', __('You administrate')) !!}
                                                    @elseif(hasModerator($guild['permissions'])) {!! getDiscordBadgeServerIcons('moderator', __('You moderate')) !!} @endif
                                                    @if(in_array('VERIFIED', $guild['features'])) {!! getDiscordBadgeServerIcons('verified', __('Discord Verified')) !!} @endif
                                                    @if(in_array('PARTNERED', $guild['features'])) {!! getDiscordBadgeServerIcons('partner', __('Discord Partner')) !!} @endif
                                                </p>
                                                <p class="text-gray-400">
                                                    {{ $guild['id'] }} &bull; {{ date('Y-m-d', getTimestamp($guild['id']) / 1000) }}
                                                </p>
                                            </td>
                                            <td class="py-3 pl-3 text-right">
                                                <a role="button"
                                                   href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}"
                                                   target="_blank"
                                                   class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                >
                                                    {{ __('Guild Lookup') }}
                                                </a>

                                                <button
                                                    x-on:click="modalFeaturesOpen = true"
                                                    wire:click="$emitTo('modal.guild-features', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')"
                                                    class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                >
                                                    {{ __('Features') }}
                                                </button>

                                                <button
                                                    x-on:click="modalPermissionsOpen = true"
                                                    wire:click="$emitTo('modal.guild-permissions', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')"
                                                    class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                >
                                                    {{ __('Permissions') }}
                                                </button>

                                                <button
                                                    x-on:click="modalExperimentsOpen = true"
                                                    wire:click="$emitTo('modal.guild-experiments', 'update', '{{ $guild['id'] }}', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')"
                                                    class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                >
                                                    {{ __('Experiments') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endauth
    </div>

    <script>
        window.addEventListener('scrollToSearch', () => document.getElementById('scrollToSearch').scrollIntoView(true))
    </script>

    @livewire('modal.guild-features')
    @livewire('modal.guild-permissions')
    @livewire('modal.guild-experiments')
</div>
