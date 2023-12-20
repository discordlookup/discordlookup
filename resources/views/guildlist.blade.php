@section('title', __('Guild List'))
@section('description', __('Show all the guilds you are on, with counters, permissions, features, experiments and more information about the guilds.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div x-data="{ modalExperimentsOpen: false, modalFeaturesOpen: false, modalPermissionsOpen: false }">
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Guild List') }}</h2>
    <div class="py-12">
        @guest
            <x-login-required class="xl:max-w-3xl" />
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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-x-0 md:gap-x-3 gap-y-3 md:gap-y-0">
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
                        <div class="px-5 py-3 grow w-full">
                            <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                                @foreach($this->guildsJsonSearch as $guild)
                                    <x-guild-table-row :guild="$guild" />
                                    @if(!$loop->last)
                                        <hr class="opacity-10" />
                                    @endif
                                @endforeach
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
