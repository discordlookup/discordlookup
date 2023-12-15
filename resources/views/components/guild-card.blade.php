<div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
    <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
        @if(array_key_exists('iconUrl', $guild) && $guild['iconUrl'])
            <div class="mr-4">
                <a href="{{ $guild['iconUrl'] }}" target="_blank">
                    <img src="{{ $guild['iconUrl'] }}" loading="lazy" alt="Guild Icon" class="inline-block w-16 h-16 rounded-full"/>
                </a>
            </div>
        @endif
        <div>
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
            <div class="ml-auto">
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
    <div class="p-5 lg:p-6 grow w-full">
        @if(array_key_exists('description', $guild) && $guild['description'])
            <div class="mb-5">
                {{ $guild['description'] }}
            </div>
            <hr class="my-6 opacity-10"/>
        @endif
        <table class="min-w-full align-middle whitespace-nowrap">
            <tbody>
            @if($guild['id'])
                <tr>
                    <td class="font-semibold">{{ __('Created') }}:</td>
                    <td>
                        <a href="{{ route('timestamp', ['timestampSlug' => round(getTimestamp($guild['id']) / 1000)]) }}">
                            {{ date('Y-m-d G:i:s \(T\)', getTimestamp($guild['id']) / 1000) }}
                            <span class="text-sm">({{ \Carbon\Carbon::createFromTimestamp(getTimestamp($guild['id']) / 1000)->diffForHumans() }})</span>
                        </a>
                    </td>
                </tr>
            @endif

            @if(array_key_exists('id', $guild) && $guild['id'])
                <tr>
                    <td class="font-semibold">{{ __('Guild ID') }}:</td>
                    <td>
                        <a href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                            {{ $guild['id'] }}
                        </a>
                    </td>
                </tr>
            @endif

            @if(array_key_exists('features', $guild) && !empty($guild['features']))
                <tr>
                    <td class="font-semibold">{{ __('Invites Paused') }}:</td>
                    <td>
                        @if(in_array('invites disabled', $guild['features']) || in_array('INVITES_DISABLED', $guild['features']))
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                        @endif
                    </td>
                </tr>
            @endif

            @if(array_key_exists('isNSFW', $guild) && $inviteType != 1)
                <tr>
                    <td class="font-semibold">{{ __('NSFW') }}:</td>
                    <td>
                        @if($guild['isNSFW'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="inline-block h-4 w-4" alt="Check">
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="inline-block h-4 w-4" alt="Cross">
                        @endif

                        @if(array_key_exists('isNSFWLevel', $guild) && $guild['isNSFW'])
                            <span class="text-sm">({{ __('Level') }} {{ $guild['isNSFWLevel'] }})</span>
                        @endif
                    </td>
                </tr>
            @endif

            @if(array_key_exists('vanityUrlCode', $guild) && $guild['vanityUrlCode'])
                <tr>
                    <td class="font-semibold">{{ __('Vanity URL') }}:</td>
                    <td>
                        <a href="{{ $guild['vanityUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                            {{ str_replace('https://', '', $guild['vanityUrl']) }}
                        </a>
                    </td>
                </tr>
            @endif

            @if(array_key_exists('instantInviteUrlCode', $guild) && $guild['instantInviteUrlCode'])
                <tr>
                    <td class="font-semibold">{{ __('Instant Invite URL') }}:</td>
                    <td>
                        <a href="{{ $guild['instantInviteUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                            {{ str_replace('https://', '', $guild['instantInviteUrl']) }}
                        </a>
                    </td>
                </tr>
            @endif

            {{-- TODO: Fetch Instant Invite Channel
            <tr>
                <td class="font-semibold">{{ __('Instant Invite Channel') }}:</td>
                <td>
                    <x-channel-name-preview :guildId="" :channelId="" :channelName="" />
                </td>
            </tr>
            --}}
            </tbody>
        </table>
        @if(array_key_exists('features', $guild) && !empty($guild['features']))
            <div>
                <div class="font-semibold">{{ __('Features') }}:</div>
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
