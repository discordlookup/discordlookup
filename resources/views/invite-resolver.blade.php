@section('title', __('Invite Resolver'))
@section('description', __('Get detailed information about every invite and vanity url including event information.'))
@section('keywords', 'event, vanity')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Invite Resolver') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <div class="space-y-1">
            <div class="relative">
                <div
                    class="absolute inset-y-0 left-0 w-28 my-px ml-px flex items-center justify-center pointer-events-none rounded-l text-gray-500">
                    {{ str_replace('https://', '', env('DISCORD_INVITE_PREFIX')) }}
                </div>
                <input
                    wire:model="inviteCodeDisplay"
                    wire:keydown.enter="fetchInvite"
                    type="text"
                    placeholder="easypoll"
                    class="block border-none rounded pl-28 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                />
            </div>
            <input
                wire:model="eventId"
                wire:keydown.enter="fetchInvite"
                type="text"
                placeholder="{{ __('Event ID') }}"
                class="block border-none rounded px-3 py-2.5 leading-4 text-sm w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </div>

        <button wire:click="fetchInvite" type="button"
                class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
            {{ __('Fetch Discord Information') }}
        </button>

        @if($inviteData === null)
            <x-error-message>
                {{ __('The entered Invite could not be found! Try again with another code.') }}
            </x-error-message>
        @elseif($inviteData)

            @if(array_key_exists('type', $inviteData) && $inviteData['type'] == 0)
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                        @if(array_key_exists('iconUrl', $inviteData['guild']) && $inviteData['guild']['iconUrl'])
                            <div class="mr-4">
                                <a href="{{ $inviteData['guild']['iconUrl'] }}" target="_blank">
                                    <img src="{{ $inviteData['guild']['iconUrl'] }}" loading="lazy" alt="Guild Icon"
                                         class="inline-block w-16 h-16 rounded-full"/>
                                </a>
                            </div>
                        @endif
                        <div>
                            <p>
                                <span class="font-semibold">{{ $inviteData['guild']['name'] }}</span>

                                @if(array_key_exists('isPartnered', $inviteData['guild']) && $inviteData['guild']['isPartnered'])
                                    <img src="{{ asset('images/discord/icons/server/partner.svg') }}"
                                         class="inline-block h-4 w-4 mb-1" alt="discord partner badge"/>
                                @endif

                                @if(array_key_exists('isVerified', $inviteData['guild']) && $inviteData['guild']['isVerified'])
                                    <img src="{{ asset('images/discord/icons/server/verified.svg') }}"
                                         class="inline-block h-4 w-4 mb-1" alt="discord verified badge"/>
                                @endif
                            </p>
                            <p>
                                @if(array_key_exists('onlineCount', $inviteData['guild']) && $inviteData['guild']['onlineCount'])
                                    <span class="inline-block h-2 w-2 rounded-full bg-[#3ba55d] mb-px mr-0.5"></span>
                                    <span
                                        class="text-sm">{{ number_format($inviteData['guild']['onlineCount'], 0, '', '.') }} {{ __('Online') }}</span>
                                @endif

                                @if(array_key_exists('memberCount', $inviteData['guild']) && $inviteData['guild']['memberCount'])
                                    <span
                                        class="inline-block h-2 w-2 rounded-full bg-[#747f8d] mb-px mr-0.5 ml-3"></span>
                                    <span
                                        class="text-sm">{{ number_format($inviteData['guild']['memberCount'], 0, '', '.') }} {{ __('Members') }}</span>
                                @endif
                            </p>
                            @if(array_key_exists('boostCount', $inviteData['guild']) && array_key_exists('boostLevel', $inviteData['guild']) && $inviteData['type'] != 1)
                                <p>
                                    {!! getDiscordBadgeServerBoosts($inviteData['guild']['boostLevel']) !!}
                                    <span
                                        class="text-sm">{{ number_format($inviteData['guild']['boostCount'], 0, '', '.') }} {{ __('Boosts') }}</span>
                                    <span
                                        class="text-xs">({{ __('Level') }} {{ $inviteData['guild']['boostLevel'] }})</span>
                                </p>
                            @endif
                        </div>
                        @if(array_key_exists('bannerUrl', $inviteData['guild']) && $inviteData['guild']['bannerUrl'])
                            <div class="ml-auto">
                                <a href="{{ $inviteData['guild']['bannerUrl'] }}" target="_blank">
                                    <img
                                        src="{{ $inviteData['guild']['bannerUrl'] }}"
                                        loading="lazy"
                                        alt="Guild Banner"
                                        class="inline-block h-16 rounded-md"
                                    />
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="p-5 lg:p-6 grow w-full">
                        @if(array_key_exists('description', $inviteData['guild']) && $inviteData['guild']['description'])
                            <div class="mb-5">
                                {{ $inviteData['guild']['description'] }}
                            </div>
                            <hr class="my-6 opacity-10"/>
                        @endif
                        <table class="min-w-full align-middle whitespace-nowrap">
                            <tbody>
                            @if(array_key_exists('id', $inviteData['guild']) && $inviteData['guild']['id'])
                                <tr>
                                    <td class="font-semibold">{{ __('Guild ID') }}:</td>
                                    <td>
                                        <a href="{{ route('guildlookup') }}/{{ $inviteData['guild']['id'] }}"
                                           class="text-discord-blurple">
                                            {{ $inviteData['guild']['id'] }}
                                        </a>
                                    </td>
                                </tr>
                            @endif

                            {{-- TODO: Created date
                            <tr>
                                <td class="font-semibold">{{ __('Created') }}:</td>
                                <td>x</td>
                            </tr>
                            --}}

                            @if(array_key_exists('features', $inviteData['guild']) && !empty($inviteData['guild']['features']))
                                <tr>
                                    <td class="font-semibold">{{ __('Invites Paused') }}:</td>
                                    <td>
                                        @if(in_array('invites disabled', $inviteData['guild']['features']) || in_array('INVITES_DISABLED', $inviteData['guild']['features']))
                                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4"
                                                 alt="Check">
                                        @else
                                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4"
                                                 alt="Cross">
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @if(array_key_exists('isNSFW', $inviteData['guild']) && $inviteData['type'] != 1)
                                <tr>
                                    <td class="font-semibold">{{ __('NSFW') }}:</td>
                                    <td>
                                        @if($inviteData['guild']['isNSFW'])
                                            <img src="{{ asset('images/discord/icons/check.svg') }}"
                                                 class="inline-block h-4 w-4" alt="Check">
                                        @else
                                            <img src="{{ asset('images/discord/icons/cross.svg') }}"
                                                 class="inline-block h-4 w-4" alt="Cross">
                                        @endif

                                        @if(array_key_exists('isNSFWLevel', $inviteData['guild']) && $inviteData['guild']['isNSFW'])
                                            <span
                                                class="text-sm">({{ __('Level') }} {{ $inviteData['guild']['isNSFWLevel'] }})</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @if(array_key_exists('vanityUrlCode', $inviteData['guild']) && $inviteData['guild']['vanityUrlCode'])
                                <tr>
                                    <td class="font-semibold">{{ __('Vanity URL') }}:</td>
                                    <td>
                                        <a href="{{ $inviteData['guild']['vanityUrl'] }}" target="_blank" rel="noopener"
                                           class="text-discord-blurple">
                                            {{ str_replace('https://', '', $inviteData['guild']['vanityUrl']) }}
                                        </a>
                                    </td>
                                </tr>
                            @endif

                            @if(array_key_exists('instantInviteUrlCode', $inviteData['guild']) && $inviteData['guild']['instantInviteUrlCode'])
                                <tr>
                                    <td class="font-semibold">{{ __('Instant Invite URL') }}:</td>
                                    <td>
                                        <a href="{{ $inviteData['guild']['instantInviteUrl'] }}" target="_blank"
                                           rel="noopener" class="text-discord-blurple">
                                            {{ str_replace('https://', '', $inviteData['guild']['instantInviteUrl']) }}
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
                        @if(array_key_exists('features', $inviteData['guild']) && !empty($inviteData['guild']['features']))
                            <div>
                                <div class="font-semibold">{{ __('Features') }}:</div>
                                <div>
                                    <ul class="list-inside list-disc capitalize">
                                        @foreach($inviteData['guild']['features'] as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif(array_key_exists('type', $inviteData) && $inviteData['type'] == 1)
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="py-4 px-5 lg:px-6 w-full flex items-center">
                        @if(array_key_exists('iconUrl', $inviteData['channel']) && $inviteData['channel']['iconUrl'])
                            <div class="mr-4">
                                <a href="{{ $inviteData['channel']['iconUrl'] }}" target="_blank">
                                    <img src="{{ $inviteData['channel']['iconUrl'] }}" loading="lazy" alt="Group Icon"
                                         class="inline-block w-16 h-16 rounded-full"/>
                                </a>
                            </div>
                        @endif
                        <div>
                            <p>
                                <span class="font-semibold">{{ $inviteData['channel']['name'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @elseif(array_key_exists('type', $inviteData) && $inviteData['type'] == 2 && array_key_exists('inviter', $inviteData) && $inviteData['inviter'])
                <x-user-card :user="$inviteData['inviter']"/>
            @endif

            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                    <h3 class="font-semibold">{{ __('Invite') }}</h3>
                </div>
                <div class="p-5 lg:p-6 grow w-full">
                    <table class="min-w-full align-middle whitespace-nowrap">
                        <tbody>
                        @if(array_key_exists('typeName', $inviteData) && $inviteData['typeName'] != null)
                            <tr>
                                <td class="font-semibold">{{ __('Type') }}:</td>
                                <td>{{ $inviteData['typeName'] }}</td>
                            </tr>
                        @endif

                        @if(array_key_exists('id', $inviteData['channel']) && $inviteData['channel']['id'])
                            <tr>
                                <td class="font-semibold">{{ __('Channel') }}:</td>
                                <td>
                                    <x-channel-name-preview
                                        guildId="{{ $inviteData['guild']['id'] ?: '@me' }}"
                                        :channelId="$inviteData['channel']['id']"
                                        channelName="{{ (array_key_exists('name', $inviteData['channel']) && $inviteData['channel']['name']) ? $inviteData['channel']['name'] : $inviteData['channel']['id'] }}"
                                    />
                                </td>
                            </tr>
                        @endif

                        @if(array_key_exists('expiresAtFormatted', $inviteData) && $inviteData['expiresAtFormatted'])
                            <tr>
                                <td class="font-semibold">{{ __('Expires') }}:</td>
                                <td>
                                    {{-- TODO: Tooltip $inviteData['expiresAt'] --}}
                                    {!! $inviteData['expiresAtFormatted'] !!}
                                </td>
                            </tr>
                        @endif

                        {{-- TODO: Check channelRecipients
                        @if(array_key_exists('recipients', $inviteData['channel']) && !empty($inviteData['channel']['recipients']))
                            <tr>
                                <td class="font-semibold">{{ __('Recipients') }}:</td>
                                <td>
                                    <ul>
                                        @foreach($inviteData['channel']['recipients'] as $recipient)
                                            <li>{{ $recipient['username'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                        --}}

                        {{-- TODO: Invite target_application --}}
                        </tbody>
                    </table>
                </div>
            </div>

            @if(array_key_exists('type', $inviteData) && $inviteData['type'] != 2 && $inviteData['inviter'] && $inviteData['inviter']['id'])
                <x-user-card :title="__('Inviter')" :user="$inviteData['inviter']"/>
            @endif

            @if($inviteData['hasEvent'])
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                        <h3 class="font-semibold">{{ __('Event') }}</h3>
                    </div>
                    <div class="p-5 lg:p-6 grow w-full">
                        <table class="min-w-full align-middle whitespace-nowrap">
                            <tbody>
                            @if($inviteData['event']['id'])
                                <tr>
                                    <td class="font-semibold">{{ __('Event ID') }}:</td>
                                    <td>{{ $inviteData['event']['id'] }}</td>
                                </tr>
                            @endif

                            @if($inviteData['event']['channelId'])
                                <tr>
                                    <td class="font-semibold">{{ __('Channel ID') }}:</td>
                                    <td>
                                        <a href="https://discord.com/channels/{{ $inviteData['guild']['id'] }}/{{ $inviteData['event']['channelId'] }}"
                                           target="_blank" rel="noopener" class="text-discord-blurple">
                                            {{ $inviteData['event']['channelId'] }}
                                        </a>
                                    </td>
                                </tr>
                            @endif

                            @if($inviteData['event']['creatorId'])
                                <tr>
                                    <td class="font-semibold">{{ __('Creator ID') }}:</td>
                                    <td>
                                        <a href="{{ route('userlookup', ['snowflake' => $inviteData['event']['creatorId']]) }}"
                                           class="text-discord-blurple">
                                            {{ $inviteData['event']['creatorId'] }}
                                        </a>
                                    </td>
                                </tr>
                            @endif

                            @if($inviteData['event']['name'])
                                <tr>
                                    <td class="font-semibold">{{ __('Name') }}:</td>
                                    <td>{{ $inviteData['event']['name'] }}</td>
                                </tr>
                            @endif

                            @if($inviteData['event']['description'])
                                <tr>
                                    <td class="font-semibold">{{ __('Description') }}:</td>
                                    <td>{{ $inviteData['event']['description'] }}</td>
                                </tr>
                            @endif

                            @if($inviteData['event']['status'])
                                <tr>
                                    <td class="font-semibold">{{ __('Status') }}:</td>
                                    <td>{!! $inviteData['event']['status'] !!}</td>
                                </tr>
                            @endif

                            @if($inviteData['event']['startTimeFormatted'])
                                <tr>
                                    <td class="font-semibold">{{ __('Start') }}:</td>
                                    <td>
                                        {{-- TODO: Tooltip $inviteData['event']['startTime'] --}}
                                        {!! $inviteData['event']['startTimeFormatted'] !!}
                                    </td>
                                </tr>
                            @endif

                            @if($inviteData['event']['endTime'])
                                <tr>
                                    <td class="font-semibold">End:</td>
                                    <td>
                                        {{-- TODO: Tooltip $inviteData['event']['endTime'] --}}
                                        {!! $inviteData['event']['endTimeFormatted'] !!}
                                    </td>
                                </tr>
                            @endif

                            @if($inviteData['event']['privacyLevel'])
                                <tr>
                                    <td class="font-semibold">{{ __('Privacy Level') }}:</td>
                                    <td>{{ $inviteData['event']['privacyLevel'] }}</td>
                                </tr>
                            @endif

                            @if($inviteData['event']['entityId'])
                                <tr>
                                    <td class="font-semibold">{{ __('Entity ID') }}:</td>
                                    <td>{{ $inviteData['event']['entityId'] }}</td>
                                </tr>
                            @endif

                            @if($inviteData['event']['entityType'])
                                <tr>
                                    <td class="font-semibold">{{ __('Entity Type') }}:</td>
                                    <td>{{ $inviteData['event']['entityType'] }}</td>
                                </tr>
                            @endif

                            @if($inviteData['event']['entityMetadataLocation'])
                                <tr>
                                    <td class="font-semibold">{{ __('Entity Location') }}:</td>
                                    <td>
                                        @if(str_starts_with($inviteData['event']['entityMetadataLocation'], 'https://'))
                                            {{-- TODO: Upgrade Laravel 10 use Str::isUrl() --}}
                                            <a href="{{ $inviteData['event']['entityMetadataLocation'] }}"
                                               target="_blank" rel="noopener" class="text-discord-blurple">
                                                {{ $inviteData['event']['entityMetadataLocation'] }}
                                            </a>
                                        @else
                                            {{ $inviteData['event']['entityMetadataLocation'] }}
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @if($inviteData['event']['userCount'])
                                <tr>
                                    <td class="font-semibold">{{ __('Interested Users') }}:</td>
                                    <td>{{ number_format($inviteData['event']['userCount'], 0, '', '.') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        @if($inviteData['event']['imageUrl'])
                            <div class="text-center mt-5">
                                <a href="{{ $inviteData['event']['imageUrl'] }}" target="_blank">
                                    <img
                                        src="{{ $inviteData['event']['imageUrl'] }}"
                                        loading="lazy"
                                        alt="Guild Scheduled Event Cover"
                                        class="inline-block rounded-md"
                                    />
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(array_key_exists('emojis', $inviteData['guild']) && !empty($inviteData['guild']['emojis']))
                <script>
                    urls = [];
                </script>
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div
                        class="py-4 px-5 lg:px-6 w-full flex items-center justify-between border-b border-discord-gray-4">
                        <div class="flex space-x-1">
                            <h3 class="font-semibold">{{ __('Emojis') }}</h3>
                            <span class="mt-0.5 text-sm">({{ sizeof($inviteData['guild']['emojis']) }})</span>
                        </div>
                        <div class="mt-3 sm:mt-0 text-center sm:text-right">
                            <button type="button" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
                                {{ __('Download') }}
                            </button>
                        </div>
                    </div>
                    <div class="p-5 lg:p-6 grow w-full">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @foreach($inviteData['guild']['emojis'] as $emoji)
                                <script>
                                    urls.push('{{ getCustomEmojiUrl($emoji['id'], 1024, 'webp', $emoji['animated']) }}');
                                </script>
                                <div class="w-full flex items-center">
                                    <div class="mr-4">
                                        <a href="{{ getCustomEmojiUrl($emoji['id'], 1024, 'webp', $emoji['animated']) }}"
                                           target="_blank">
                                            <img
                                                src="{{ getCustomEmojiUrl($emoji['id'], 64, 'webp', $emoji['animated']) }}"
                                                loading="lazy"
                                                alt="{{ $emoji['name'] }} Emoji"
                                                class="inline-block w-9 h-9"
                                            />
                                        </a>
                                    </div>
                                    <div>
                                        <p>{{ $emoji['name'] }}</p>
                                        <p class="text-gray-500 text-sm">{{ $emoji['id'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if(array_key_exists('stickers', $inviteData['guild']) && !empty($inviteData['guild']['stickers']))
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="py-4 px-5 lg:px-6 w-full flex items-center justify-between border-b border-discord-gray-4">
                        <div class="flex space-x-1">
                            <h3 class="font-semibold">{{ __('Sticker') }}</h3>
                            <span class="mt-0.5 text-sm">({{ sizeof($inviteData['guild']['stickers']) }})</span>
                        </div>
                        <div class="mt-3 sm:mt-0 text-center sm:text-right">
                            <button type="button" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
                                {{ __('Download') }}
                            </button>
                        </div>
                    </div>
                    <div class="p-5 lg:p-6 grow w-full">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-4">
                            @foreach($inviteData['guild']['stickers'] as $sticker)
                                <div class="w-full flex items-center">
                                    <div class="mr-4">
                                        <a href="{{ getStickerUrl($sticker['id']) }}"
                                           target="_blank">
                                            <img
                                                src="{{ getStickerUrl($sticker['id']) }}"
                                                loading="lazy"
                                                alt="{{ $sticker['name'] }} Sticker"
                                                class="inline-block w-16"
                                            />
                                        </a>
                                    </div>
                                    <div>
                                        <p>{{ $sticker['name'] }}</p>
                                        <p class="text-gray-300 text-sm">{{ $sticker['description'] }}</p>
                                        <p class="text-gray-400 text-sm">{{ __('Tags') }}: {{ $sticker['tags'] }}</p>
                                        <p class="text-gray-500 text-sm">{{ $sticker['id'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if(array_key_exists('channels', $inviteData['guild']) && !empty($inviteData['guild']['channels']))
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                        <div class="flex space-x-1">
                            <h3 class="font-semibold">{{ __('Voice Channels') }}</h3>
                            <span class="mt-0.5 text-sm">({{ sizeof($inviteData['guild']['channels']) }})</span>
                        </div>
                    </div>
                    <div class="p-5 lg:p-6 grow w-full">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @foreach($inviteData['guild']['channels'] as $channel)
                                <x-channel-name-preview
                                    :guildId="$inviteData['guild']['id']"
                                    :channelId="$channel['id']"
                                    :channelName="$channel['name']"
                                />
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if(array_key_exists('members', $inviteData['guild']) && !empty($inviteData['guild']['members']))
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                        <div class="flex space-x-1">
                            <h3 class="font-semibold">{{ __('Members') }}</h3>
                            <span class="mt-0.5 text-sm">({{ sizeof($inviteData['guild']['members']) >= 100 ? sizeof($inviteData['guild']['members']) . '+' : sizeof($inviteData['guild']['members']) }})</span>
                        </div>
                    </div>
                    <div class="p-5 lg:p-6 grow w-full">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @foreach($inviteData['guild']['members'] as $member)
                                <div class="w-full flex items-center">
                                    <div class="mr-4">
                                        <a href="{{ $member['avatar_url'] }}" target="_blank">
                                            <div class="relative inline-block">
                                                @if($member['status'] == 'online')
                                                    <div class="absolute -right-1 -bottom-1 h-4 w-4 rounded-full border-2 border-discord-gray-1 bg-[#23a359]"></div>
                                                @elseif($member['status'] == 'dnd')
                                                    <div class="absolute -right-1 -bottom-1 h-4 w-4 rounded-full border-2 border-discord-gray-1 bg-[#f13f43]"></div>
                                                @elseif($member['status'] == 'idle')
                                                    <div class="absolute -right-1 -bottom-1 h-4 w-4 rounded-full border-2 border-discord-gray-1 bg-[#f0b232]"></div>
                                                @endif
                                                <img
                                                    src="{{ $member['avatar_url'] }}"
                                                    loading="lazy"
                                                    alt="{{ $member['username'] }} Avatar"
                                                    class="inline-block w-9 h-9 rounded-full"
                                                />
                                            </div>
                                        </a>
                                    </div>
                                    <p>{{ $member['username'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>

    {{-- TODO:
        @if($loading)
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
            </div>
        @elseif($inviteData === null)

        @elseif($inviteData)
            <div class="col-12 col-lg-6 offset-lg-3">
                <div class="card text-white bg-dark">

                    <div class="card-body">

                        <div>




                            @if(array_key_exists('emojis', $inviteData['guild']) && !empty($inviteData['guild']['emojis']))

                                <button id="buttonDownloadAllEmojis" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#emojiDownloadModal">
                                    <i class="fas fa-download"></i> {{ __('Download all Guild Emojis') }}
                                </button>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if($inviteData && array_key_exists('id', $inviteData['guild']))
            <div class="modal fade" id="emojiDownloadModal" tabindex="-1" aria-labelledby="emojiDownloadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark border-0">
                        <div class="modal-header justify-content-center">
                            <h5 class="modal-title fw-bold" id="emojiDownloadModalLabel">{{ __('Legal Notice') }}</h5>
                        </div>
                        <div class="modal-body text-center">
                            {{ __('Emojis of some Servers could be protected by applicable copyright law.') }}<br>
                            {{ __('The emojis will be downloaded locally on your device and you have to ensure that you don\'t infrige anyones copyright while using them.') }}<br>
                            <b>{{ __('NO LIABILITY WILL BE GIVEN FOR ANY DAMAGES CAUSED BY USING THESE FILES') }}</b>
                        </div>
                        <div class="modal-footer bg-dark justify-content-center">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="downloadEmojis('{{ $inviteData['guild']['id'] }}', urls)">{{ __('Confirm') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        --}}

    <script>
        document.addEventListener('DOMContentLoaded', () => fetchInvite('{{ $inviteCode }}', '{{ $eventId }}'));
        window.addEventListener('fetchInvite', event => fetchInvite(event.detail.inviteCode, event.detail.eventId));

        function fetchInvite(inviteCode, eventId) {
            if (!inviteCode) return;
            $.ajax({
                type: 'GET',
                url: '{{ env('DISCORD_API_URL') }}/invites/' + inviteCode + '?with_counts=true&with_expiration=true' + ((eventId !== '' && eventId != null) ? '&guild_scheduled_event_id=' + eventId : ''),
                success: (respond) => Livewire.emit('processInviteJson', respond),
                error: () => Livewire.emit('processInviteJson', null),
            });
        }

        var urls = [];

        function downloadEmojis(guildId, urls) {
            document.getElementById('buttonDownloadAllEmojis').disabled = true;
            document.getElementById('buttonDownloadAllEmojis').innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('Downloading...') }}';

            // https://gist.github.com/c4software/981661f1f826ad34c2a5dc11070add0f#gistcomment-3372574
            var zip = new JSZip();
            var count = 0;
            var filenameCounter = 0;
            var fileNames = [];
            for (var i = 0; i < urls.length; i++) {
                fileNames[i] = urls[i].split('/').pop();
            }
            urls.forEach(function (url) {
                var filename = fileNames[filenameCounter];
                filenameCounter++;
                JSZipUtils.getBinaryContent(url, function (err, data) {
                    if (err) throw err;
                    zip.file(filename, data, {binary: true});
                    count++;
                    if (count === urls.length) {
                        zip.generateAsync({type: 'blob'}).then(function (content) {
                            saveAs(content, 'emojis_' + guildId + '.zip');
                            document.getElementById('buttonDownloadAllEmojis').disabled = false;
                            document.getElementById('buttonDownloadAllEmojis').innerHTML = '<i class="fas fa-download"></i> {{ __('Download all Guild Emojis') }}';
                        });
                    }
                });
            });
        }
    </script>
</div>
