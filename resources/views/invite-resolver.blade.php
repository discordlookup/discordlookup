@section('title', __('Invite Resolver'))
@section('description', __('Get detailed information about every invite and vanity url including event information.'))
@section('keywords', 'event, vanity')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Invite Resolver') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <div class="space-y-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 w-28 my-px ml-px flex items-center justify-center pointer-events-none rounded-l text-gray-500">
                    {{ str_replace('https://', '', env('DISCORD_INVITE_PREFIX')) }}
                </div>
                <input
                    wire:model.defer="inviteCodeDisplay"
                    wire:keydown.enter="fetchInvite"
                    type="text"
                    placeholder="easypoll"
                    class="block border-none rounded pl-28 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                />
            </div>
            <input
                wire:model.defer="eventId"
                wire:keydown.enter="fetchInvite"
                type="text"
                placeholder="{{ __('Event ID') }}"
                class="block border-none rounded px-3 py-2.5 leading-4 text-sm w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </div>

        <button
            wire:click="fetchInvite"
            type="button"
            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full text-white {{ $loading ? 'border-[#414aa5] bg-[#414aa5] cursor-not-allowed' : 'border-discord-blurple bg-discord-blurple hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]' }}"
            {{ $loading ? 'disabled' : '' }}
        >
            @if($loading)
                <i class="fas fa-spinner fa-spin"></i> {{ __('Fetching...') }}
            @else
                {{ __('Fetch Discord Information') }}
            @endif
        </button>

        @if($inviteData === null)
            <x-error-message>
                {{ __('The entered Invite could not be found! Try again with another code.') }}
            </x-error-message>
        @endif

        @if($inviteData)
            @if(array_key_exists('type', $inviteData) && $inviteData['type'] == 0)
                <x-guild-card :guild="$inviteData['guild']" :invite-type="$inviteData['type']" />
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
                    <div class="flex flex-col gap-y-5 md:gap-y-0.5 mb-5 md:mb-0">
                        @if(array_key_exists('typeName', $inviteData) && $inviteData['typeName'] != null)
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Type') }}<span class="hidden md:inline">:</span></span>
                                <p>{{ $inviteData['typeName'] }}</p>
                            </div>
                        @endif

                        @if(array_key_exists('id', $inviteData['channel']) && $inviteData['channel']['id'])
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Channel') }}<span class="hidden md:inline">:</span></span>
                                <x-channel-name-preview
                                    guildId="{{ $inviteData['guild']['id'] ?: '@me' }}"
                                    :channelId="$inviteData['channel']['id']"
                                    channelName="{{ (array_key_exists('name', $inviteData['channel']) && $inviteData['channel']['name']) ? $inviteData['channel']['name'] : $inviteData['channel']['id'] }}"
                                />
                            </div>
                        @endif

                        @if(array_key_exists('expiresAtFormatted', $inviteData) && $inviteData['expiresAtFormatted'])
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Expires') }}<span class="hidden md:inline">:</span></span>
                                <p>
                                    {{-- TODO: Tooltip $inviteData['expiresAt'] --}}
                                    {!! $inviteData['expiresAtFormatted'] !!}
                                </p>
                            </div>
                        @endif

                        {{-- TODO: Check channelRecipients
                        @if(array_key_exists('recipients', $inviteData['channel']) && !empty($inviteData['channel']['recipients']))
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Recipients') }}<span class="hidden md:inline">:</span></span>
                                <p>
                                    <ul>
                                        @foreach($inviteData['channel']['recipients'] as $recipient)
                                            <li>{{ $recipient['username'] }}</li>
                                        @endforeach
                                    </ul>
                                </p>
                            </div>
                        @endif
                        --}}

                        {{-- TODO: Invite target_application --}}
                    </div>
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
                        <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                            @if($inviteData['event']['id'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Event ID') }}<span class="hidden md:inline">:</span></span>
                                    <p>{{ $inviteData['event']['id'] }}</p>
                                </div>
                            @endif

                            @if($inviteData['event']['channelId'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Channel ID') }}<span class="hidden md:inline">:</span></span>
                                    <p>
                                        <a href="https://discord.com/channels/{{ $inviteData['guild']['id'] }}/{{ $inviteData['event']['channelId'] }}"
                                           target="_blank" rel="noopener" class="text-discord-blurple">
                                            {{ $inviteData['event']['channelId'] }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if($inviteData['event']['creatorId'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Creator ID') }}<span class="hidden md:inline">:</span></span>
                                    <p>
                                        <a href="{{ route('userlookup', ['snowflake' => $inviteData['event']['creatorId']]) }}"
                                           class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                            {{ $inviteData['event']['creatorId'] }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if($inviteData['event']['name'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Name') }}<span class="hidden md:inline">:</span></span>
                                    <p>{{ $inviteData['event']['name'] }}</p>
                                </div>
                            @endif

                            @if($inviteData['event']['description'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Description') }}<span class="hidden md:inline">:</span></span>
                                    <p>{{ $inviteData['event']['description'] }}</p>
                                </div>
                            @endif

                            @if($inviteData['event']['status'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Status') }}<span class="hidden md:inline">:</span></span>
                                    <p>{!! $inviteData['event']['status'] !!}</p>
                                </div>
                            @endif

                            @if($inviteData['event']['startTimeFormatted'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Start') }}<span class="hidden md:inline">:</span></span>
                                    <p>
                                        {{-- TODO: Tooltip $inviteData['event']['startTime'] --}}
                                        {!! $inviteData['event']['startTimeFormatted'] !!}
                                    </p>
                                </div>
                            @endif

                            @if($inviteData['event']['endTime'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('End') }}<span class="hidden md:inline">:</span></span>
                                    <p>
                                        {{-- TODO: Tooltip $inviteData['event']['endTime'] --}}
                                        {!! $inviteData['event']['endTimeFormatted'] !!}
                                    </p>
                                </div>
                            @endif

                            @if($inviteData['event']['privacyLevel'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Privacy Level') }}<span class="hidden md:inline">:</span></span>
                                    <p>{{ $inviteData['event']['privacyLevel'] }}</p>
                                </div>
                            @endif

                            @if($inviteData['event']['entityId'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Entity ID') }}<span class="hidden md:inline">:</span></span>
                                    <p>{{ $inviteData['event']['entityId'] }}</p>
                                </div>
                            @endif

                            @if($inviteData['event']['entityType'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Entity Type') }}<span class="hidden md:inline">:</span></span>
                                    <p>{{ $inviteData['event']['entityType'] }}</p>
                                </div>
                            @endif

                            @if($inviteData['event']['entityMetadataLocation'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Entity Location') }}<span class="hidden md:inline">:</span></span>
                                    <p>
                                        @if(Str::isUrl($inviteData['event']['entityMetadataLocation'], ['http', 'https'])))
                                            <a href="{{ $inviteData['event']['entityMetadataLocation'] }}"
                                               target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                                {{ $inviteData['event']['entityMetadataLocation'] }}
                                            </a>
                                        @else
                                            {{ $inviteData['event']['entityMetadataLocation'] }}
                                        @endif
                                    </p>
                                </div>
                            @endif

                            @if($inviteData['event']['userCount'])
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    <span class="font-semibold">{{ __('Interested Users') }}<span class="hidden md:inline">:</span></span>
                                    <p>{{ number_format($inviteData['event']['userCount'], 0, '', '.') }}</p>
                                </div>
                            @endif
                        </div>

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
                <x-emoji-card :emojis="$inviteData['guild']['emojis']" :guild-id="$inviteData['guild']['id']" />
            @endif

            @if(array_key_exists('stickers', $inviteData['guild']) && !empty($inviteData['guild']['stickers']))
                <x-sticker-card :stickers="$inviteData['guild']['stickers']" :guild-id="$inviteData['guild']['id']" />
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            @foreach($inviteData['guild']['members'] as $member)
                                <div class="w-full flex items-center">
                                    <div class="mr-4">
                                        <a href="{{ $member['avatar_url'] }}" target="_blank">
                                            <div class="relative inline-block">
                                                <div class="absolute -right-1 -bottom-1 h-4 w-4 rounded-full border-2 border-discord-gray-1 {{ $member['status'] == 'online' ? 'bg-[#23a359]' : ($member['status'] == 'dnd' ? 'bg-[#f13f43]' : ($member['status'] == 'idle' ? 'bg-[#f0b232]' : 'bg-discord-gray-1')) }}"></div>
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
    </script>
</div>
