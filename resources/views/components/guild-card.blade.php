<div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
    @if(array_key_exists('name', $guild) && $guild['name'])
        <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
            <div class="flex flex-col gap-y-5 md:gap-y-0.5 grow w-full">
                <div class="grid grid-cols-1 md:grid-cols-8 gap-y-3">
                    <div class="col-span-1 text-center md:text-left my-auto">
                        @if(array_key_exists('iconUrl', $guild) && $guild['iconUrl'])
                            <a href="{{ $guild['iconUrl'] }}" target="_blank">
                                <img src="{{ $guild['iconUrl'] }}" loading="lazy" alt="Guild Icon" class="inline-block w-16 h-16 rounded-full"/>
                            </a>
                        @endif
                    </div>
                    <div class="col-span-4 text-center md:text-left my-auto">
                        <p>
                            <span class="font-semibold">{{ $guild['name'] }}</span>

                            @if(array_key_exists('isPartnered', $guild) && $guild['isPartnered'])
                                <img src="{{ asset('images/discord/icons/server/partner.svg') }}" class="inline-block h-4 w-4 mb-1" alt="discord partner badge"/>
                            @endif

                            @if(array_key_exists('isVerified', $guild) && $guild['isVerified'])
                                <img src="{{ asset('images/discord/icons/server/verified.svg') }}" class="inline-block h-4 w-4 mb-1" alt="discord verified badge"/>
                            @endif
                        </p>
                        <p>
                            @if(array_key_exists('onlineCount', $guild) && $guild['onlineCount'])
                                <span class="inline-block h-2 w-2 rounded-full bg-[#3ba55d] mb-px mr-0.5"></span>
                                <span class="text-sm">{{ number_format($guild['onlineCount'], 0, '', '.') }} {{ __('Online') }}</span>
                            @endif

                            @if(array_key_exists('memberCount', $guild) && $guild['memberCount'])
                                <span class="inline-block h-2 w-2 rounded-full bg-[#747f8d] mb-px mr-0.5 ml-3"></span>
                                <span class="text-sm">{{ number_format($guild['memberCount'], 0, '', '.') }} {{ __('Members') }}</span>
                            @endif
                        </p>
                        @if(array_key_exists('boostCount', $guild) && array_key_exists('boostLevel', $guild) && $inviteType != 1)
                            <p>
                                {!! getDiscordBadgeServerBoosts($guild['boostLevel']) !!}
                                <span class="text-sm">{{ number_format($guild['boostCount'], 0, '', '.') }} {{ __('Boosts') }}</span>
                                <span class="text-xs">({{ __('Level') }} {{ $guild['boostLevel'] }})</span>
                            </p>
                        @endif
                    </div>
                    @if(array_key_exists('bannerUrl', $guild) && $guild['bannerUrl'])
                        <div class="col-span-3 text-center md:text-right my-auto">
                            <a href="{{ $guild['bannerUrl'] }}" target="_blank">
                                <img
                                    src="{{ $guild['bannerUrl'] }}"
                                    loading="lazy"
                                    alt="Guild Banner"
                                    class="inline-block h-16 rounded-md"
                                />
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="p-5 lg:p-6 grow w-full">
        @if(array_key_exists('description', $guild) && $guild['description'])
            <div class="mb-5">
                {{ $guild['description'] }}
            </div>
            <hr class="my-6 opacity-10"/>
        @endif
        <div class="flex flex-col gap-y-5 md:gap-y-0.5 mb-5 md:mb-0">
            @if($guild['id'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Created') }}<span class="hidden md:inline">:</span></span>
                    <p>
                        <a href="{{ route('timestamp', ['timestampSlug' => round(getTimestamp($guild['id']) / 1000)]) }}">
                            {{ date('Y-m-d G:i:s \(T\)', getTimestamp($guild['id']) / 1000) }}
                            <span class="text-sm">({{ \Carbon\Carbon::createFromTimestamp(getTimestamp($guild['id']) / 1000)->diffForHumans() }})</span>
                        </a>
                    </p>
                </div>
            @endif

            @if(array_key_exists('id', $guild) && $guild['id'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Guild ID') }}<span class="hidden md:inline">:</span></span>
                    <p>
                        <a href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                            {{ $guild['id'] }}
                        </a>
                    </p>
                </div>
            @endif

            @if($inviteType == 0)
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Widget Enabled') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if(array_key_exists('widgetEnabled', $guild) && $guild['widgetEnabled'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="inline-block h-4 w-4" alt="Check">
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="inline-block h-4 w-4" alt="Cross">
                        @endif
                    </p>
                </div>
            @endif

            @if($inviteType == 0)
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Preview Enabled') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if(array_key_exists('previewEnabled', $guild) && $guild['previewEnabled'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="inline-block h-4 w-4" alt="Check">
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="inline-block h-4 w-4" alt="Cross">
                        @endif
                    </p>
                </div>
            @endif

            @if(array_key_exists('features', $guild) && !empty($guild['features']))
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Invites Paused') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if(in_array('invites disabled', $guild['features']) || in_array('INVITES_DISABLED', $guild['features']))
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                        @endif
                    </p>
                </div>
            @endif

            @if(array_key_exists('isNSFW', $guild) && $inviteType != 1)
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('NSFW') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if($guild['isNSFW'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="inline-block h-4 w-4" alt="Check">
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="inline-block h-4 w-4" alt="Cross">
                        @endif

                        @if(array_key_exists('isNSFWLevel', $guild) && $guild['isNSFW'])
                            <span class="text-sm">({{ __('Level') }} {{ $guild['isNSFWLevel'] }} - {{ $guild['isNSFWLevelName'] }})</span>
                        @endif
                    </p>
                </div>
            @endif

            @if($inviteType == 0 && array_key_exists('features', $guild) && !empty($guild['features']))
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Clan') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if(in_array('clan', $guild['features']) || in_array('CLAN', $guild['features']))
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                        @endif
                    </p>
                </div>
            @endif

            @if(array_key_exists('vanityUrlCode', $guild) && $guild['vanityUrlCode'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Vanity URL') }}<span class="hidden md:inline">:</span></span>
                    <p>
                        <a href="{{ $guild['vanityUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                            {{ str_replace('https://', '', $guild['vanityUrl']) }}
                        </a>
                    </p>
                </div>
            @endif

            @if(array_key_exists('instantInviteUrlCode', $guild) && $guild['instantInviteUrlCode'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Instant Invite URL') }}<span class="hidden md:inline">:</span></span>
                    <p>
                        <a href="{{ $guild['instantInviteUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                            {{ str_replace('https://', '', $guild['instantInviteUrl']) }}
                        </a>
                    </p>
                </div>
            @endif

            {{-- TODO: Fetch Instant Invite Channel
            <div class="grid grid-cols-1 md:grid-cols-2">
                <span class="font-semibold">{{ __('Instant Invite Channel') }}<span class="hidden md:inline">:</span></span>
                <p>
                    <x-channel-name-preview :guildId="" :channelId="" :channelName="" />
                </p>
            </div>
            --}}
        </div>
        @if(array_key_exists('features', $guild) && !empty($guild['features']))
            <div>
                <div class="font-semibold">{{ __('Features') }}<span class="hidden md:inline">:</span></div>
                <div>
                    <ul class="list-inside list-disc capitalize">
                        @foreach($guild['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
