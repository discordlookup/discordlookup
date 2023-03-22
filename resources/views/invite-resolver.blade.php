@section('title', __('Invite Resolver'))
@section('description', __('Get detailed information about every invite and vanity url including event information.'))
@section('keywords', 'event, vanity')
@section('robots', 'index, follow')

<div id="inviteresolver">
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Invite Resolver') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3 mb-5">
                <div class="input-group input-group-lg mb-2">
                    <span class="input-group-text bg-dark">{{ str_replace('https://', '', env('DISCORD_INVITE_PREFIX')) }}</span>
                    <input wire:model="inviteCodeDisplay" wire:keydown.enter="fetchInvite" type="text" class="form-control" placeholder="easypoll">
                </div>
                <input wire:model="eventId" wire:keydown.enter="fetchInvite" class="form-control mb-3" type="text" placeholder="{{ __('Event ID') }}">
                <button wire:click="fetchInvite" type="button" class="btn btn-primary w-100">{{ __('Fetch Invite Information') }}</button>
            </div>
            @if($loading)
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                    </div>
                </div>
            @elseif($inviteData === null)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('The entered Invite could not be found! Try again with another code.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                    </div>
                </div>
            @elseif($inviteData)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="card text-white bg-dark">
                        <div class="card-header">
                            <div class="row">
                                @if(array_key_exists('iconUrl', $inviteData['guild']) && $inviteData['guild']['iconUrl'])
                                    <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0">
                                        <a href="{{ $inviteData['guild']['iconUrl'] }}" target="_blank">
                                            <img src="{{ $inviteData['guild']['iconUrl'] }}" loading="lazy" class="rounded-circle" style="max-width: 64px; max-height: 64px;" alt="guild icon">
                                        </a>
                                    </div>
                                @endif
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0 mt-3 mt-sm-0 text-center text-lg-start align-self-center">
                                    @if(array_key_exists('name', $inviteData['guild']) && $inviteData['guild']['name'])
                                        <b>{{ $inviteData['guild']['name'] }}</b>
                                    @endif

                                    @if(array_key_exists('isPartnered', $inviteData['guild']) && $inviteData['guild']['isPartnered'])
                                        <img src="{{ asset('images/discord/icons/server/partner.svg') }}" class="discord-badge" alt="discord partner badge">
                                    @endif

                                    @if(array_key_exists('isVerified', $inviteData['guild']) && $inviteData['guild']['isVerified'])
                                        <img src="{{ asset('images/discord/icons/server/verified.svg') }}" class="discord-badge" alt="discord verified badge">
                                    @endif
                                    <div class="small">
                                        <div>
                                            @if(array_key_exists('onlineCount', $inviteData['guild']) && $inviteData['guild']['onlineCount'])
                                                <span class="discord-status-pill discord-status-pill-online"></span>
                                                {{ number_format($inviteData['guild']['onlineCount'], 0, '', '.') }} {{ __('Online') }}
                                            @endif

                                            @if(array_key_exists('memberCount', $inviteData['guild']) && $inviteData['guild']['memberCount'])
                                                <span class="discord-status-pill discord-status-pill-offline ms-3"></span>
                                                {{ number_format($inviteData['guild']['memberCount'], 0, '', '.') }} {{ __('Members') }}
                                            @endif
                                        </div>
                                        @if(array_key_exists('boostCount', $inviteData['guild']) && array_key_exists('boostLevel', $inviteData['guild']))
                                            <div>
                                                {!! getDiscordBadgeServerBoosts($inviteData['guild']['boostLevel']) !!}
                                                {{ number_format($inviteData['guild']['boostCount'], 0, '', '.') }} {{ __('Boosts') }}
                                                <small>({{ __('Level') }} {{ $inviteData['guild']['boostLevel'] }})</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(array_key_exists('bannerUrl', $inviteData['guild']) && $inviteData['guild']['bannerUrl'])
                                    <div class="col-auto me-auto ms-auto me-lg-0 mt-3 mt-sm-0">
                                        <a href="{{ $inviteData['guild']['bannerUrl'] }}" target="_blank">
                                            <img src="{{ $inviteData['guild']['bannerUrl'] }}" loading="lazy" class="rounded-3" style="max-height: 64px;" alt="guild banner">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if(array_key_exists('description', $inviteData['guild']) && $inviteData['guild']['description'])
                                {{ $inviteData['guild']['description'] }}
                                <hr>
                            @endif
                            <div>
                                @if(array_key_exists('channelId', $inviteData['invite']) && $inviteData['invite']['channelId'])
                                    <b>{{ __('Invite Channel') }}:</b>
                                    <a href="https://discord.com/channels/{{ $inviteData['guild']['id'] }}/{{ $inviteData['invite']['channelId'] }}" target="_blank" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteData['invite']['channelId'] }}">
                                        @if(array_key_exists('channelName', $inviteData['invite']) && $inviteData['invite']['channelName'])
                                            {{ $inviteData['invite']['channelName'] }}
                                        @else
                                            {{ $inviteData['invite']['channelId'] }}
                                        @endif
                                    </a>
                                    <br>
                                @endif

                                @if(array_key_exists('inviterId', $inviteData['invite']) && $inviteData['invite']['inviterId'])
                                    <b>{{ __('Invite Creator') }}:</b>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteData['invite']['inviterId'] }}">
                                        <a href="{{ route('userlookup', ['snowflake' => $inviteData['invite']['inviterId']]) }}">
                                            @if(array_key_exists('inviterName', $inviteData['invite']) && $inviteData['invite']['inviterName'])
                                                {{ $inviteData['invite']['inviterName'] }}
                                            @else
                                                {{ $inviteData['invite']['inviterId'] }}
                                            @endif
                                        </a>
                                    </span>
                                    <br>
                                @endif

                                @if(array_key_exists('expiresAtFormatted', $inviteData['invite']) && $inviteData['invite']['expiresAtFormatted'])
                                    <b>{{ __('Invite Expires') }}:</b>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteData['invite']['expiresAt'] }}">{!! $inviteData['invite']['expiresAtFormatted'] !!}</span><br>
                                @endif

                                <hr>

                                @if(array_key_exists('id', $inviteData['guild']) && $inviteData['guild']['id'])
                                    <b>{{ __('Guild ID') }}:</b>
                                    <a href="{{ route('guildlookup') }}/{{ $inviteData['guild']['id'] }}" class="text-decoration-none">{{ $inviteData['guild']['id'] }}</a><br>
                                @endif

                                @if(array_key_exists('instantInviteUrlCode', $inviteData['guild']) && $inviteData['guild']['instantInviteUrlCode'])
                                    <b>{{ __('Instant Invite URL') }}:</b>
                                    <a href="{{ $inviteData['guild']['instantInviteUrl'] }}" target="_blank" class="text-decoration-none">{{ $inviteData['guild']['instantInviteUrl'] }}</a><br>
                                @endif

                                @if(array_key_exists('vanityUrlCode', $inviteData['guild']) && $inviteData['guild']['vanityUrlCode'])
                                    <b>{{ __('Vanity URL') }}:</b>
                                    <a href="{{ $inviteData['guild']['vanityUrl'] }}" target="_blank" class="text-decoration-none">{{ $inviteData['guild']['vanityUrl'] }}</a><br>
                                @endif

                                @if(array_key_exists('features', $inviteData['guild']) && !empty($inviteData['guild']['features']))
                                    <b>{{ __('Invites Paused') }}:</b>
                                    @if(in_array('invites disabled', $inviteData['guild']['features']) || in_array('INVITES_DISABLED', $inviteData['guild']['features']))
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="discord-badge" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="discord-badge" alt="Cross">
                                    @endif
                                    <br>
                                @endif

                                @if(array_key_exists('isNSFW', $inviteData['guild']))
                                    <b>{{ __('NSFW') }}:</b>
                                    @if($inviteData['guild']['isNSFW'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="discord-badge" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="discord-badge" alt="Cross">
                                    @endif
                                    <br>
                                    @if(array_key_exists('isNSFWLevel', $inviteData['guild']) && $inviteData['guild']['isNSFW'])
                                        <b>{{ __('NSFW Level') }}:</b>
                                        {{ $inviteData['guild']['isNSFWLevel'] }}<br>
                                    @endif
                                @endif

                                @if(array_key_exists('features', $inviteData['guild']) && !empty($inviteData['guild']['features']))
                                    <b>{{ __('Features') }}:</b>
                                    <ul class="text-capitalize">
                                        @foreach($inviteData['guild']['features'] as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if($inviteData['hasEvent'])
                                    <hr>

                                    <b>{{ __('Event ID') }}:</b>
                                    {{ $inviteData['event']['id'] }}<br>

                                    @if($inviteData['event']['channelId'])
                                        <b>{{ __('Channel ID') }}:</b>
                                        <a href="https://discord.com/channels/{{ $inviteData['guild']['id'] }}/{{ $inviteData['event']['channelId'] }}" target="_blank" rel="noopener" class="text-decoration-none">
                                            {{ $inviteData['event']['channelId'] }}
                                        </a>
                                        <br>
                                    @endif

                                    @if($inviteData['event']['creatorId'])
                                        <b>{{ __('Creator ID') }}:</b>
                                        <a href="{{ route('userlookup', ['snowflake' => $inviteData['event']['creatorId']]) }}" class="text-decoration-none">
                                            {{ $inviteData['event']['creatorId'] }}
                                        </a>
                                        <br>
                                    @endif

                                    <b>{{ __('Name') }}:</b>
                                    {{ $inviteData['event']['name'] }}<br>

                                    @if($inviteData['event']['description'])
                                        <b>{{ __('Description') }}:</b>
                                        {{ $inviteData['event']['description'] }}<br>
                                    @endif

                                    <b>{{ __('Start') }}:</b>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteData['event']['startTime'] }}">
                                        {!! $inviteData['event']['startTimeFormatted'] !!}
                                    </span>
                                    <br>

                                    @if($inviteData['event']['endTime'])
                                        <b>{{ __('End') }}:</b>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteData['event']['endTime'] }}">
                                            {!! $inviteData['event']['endTimeFormatted'] !!}
                                        </span>
                                        <br>
                                    @endif

                                    <b>{{ __('Privacy Level') }}:</b>
                                    <span class="badge bg-body">{{ $inviteData['event']['privacyLevel'] }}</span><br>

                                    <b>{{ __('Status') }}:</b>
                                    {!! $inviteData['event']['status'] !!}<br>

                                    <b>{{ __('Entity Type') }}:</b>
                                    <span class="badge bg-body">{{ $inviteData['event']['entityType'] }}</span><br>

                                    @if($inviteData['event']['entityId'])
                                        <b>{{ __('Entity ID') }}:</b>
                                        {{ $inviteData['event']['entityId'] }}<br>
                                    @endif

                                    @if($inviteData['event']['entityMetadataLocation'])
                                        <b>{{ __('Entity Location') }}:</b>
                                        <a href="{{ $inviteData['event']['entityMetadataLocation'] }}" target="_blank" rel="noopener" class="text-decoration-none">
                                            {{ $inviteData['event']['entityMetadataLocation'] }}
                                        </a>
                                        <br>
                                    @endif

                                    @if($inviteData['event']['userCount'])
                                        <b>{{ __('Interested Users') }}:</b>
                                        {{ $inviteData['event']['userCount'] }}<br>
                                    @endif
                                @endif

                                @if(array_key_exists('emojis', $inviteData['guild']) && !empty($inviteData['guild']['emojis']))
                                    <hr>

                                    <b>{{ __('Emojis') }} ({{ sizeof($inviteData['guild']['emojis']) }}):</b><br>

                                    <script>
                                        urls = [];
                                    </script>

                                    <div class="row table-responsive mt-3">
                                        <div class="col-12 col-md-6">
                                            <table class="table table-hover shadow-none">
                                                <tbody>
                                                    @foreach($inviteData['guild']['emojis'] as $emoji)
                                                        <script>
                                                            urls.push('{{ env('DISCORD_CDN_URL') }}/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}');
                                                        </script>
                                                        @if($loop->odd)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ env('DISCORD_CDN_URL') }}/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}" target="_blank" class="text-decoration-none">
                                                                        <img src="{{ env('DISCORD_CDN_URL') }}/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}?size=32" loading="lazy" style="max-height: 32px; max-width: 32px;" alt="{{ $emoji['name'] }} emoji" title="{{ $emoji['name'] }}">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    {{ $emoji['name'] }}
                                                                    <div class="small text-muted">{{ $emoji['id'] }}</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <table class="table table-hover shadow-none">
                                                <tbody>
                                                    @foreach($inviteData['guild']['emojis'] as $emoji)
                                                        @if($loop->even)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ env('DISCORD_CDN_URL') }}/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}" target="_blank" class="text-decoration-none">
                                                                        <img src="{{ env('DISCORD_CDN_URL') }}/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}?size=32" loading="lazy" style="max-height: 32px; max-width: 32px;" alt="{{ $emoji['name'] }} emoji" title="{{ $emoji['name'] }}">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    {{ $emoji['name'] }}
                                                                    <div class="small text-muted">{{ $emoji['id'] }}</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <button id="buttonDownloadAllEmojis" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#emojiDownloadModal">
                                        <i class="fas fa-download"></i> {{ __('Download all Guild Emojis') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $(function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
            })

            Livewire.hook('message.processed', (message, component) => {
                $(function () {
                    $('[data-bs-toggle="tooltip"]').tooltip()
                })
            })
        })

        document.addEventListener('DOMContentLoaded', () => fetchInvite('{{ $inviteCode }}', '{{ $eventId }}'));
        window.addEventListener('fetchInvite', event => fetchInvite(event.detail.inviteCode, event.detail.eventId));

        function fetchInvite(inviteCode, eventId)
        {
            if(!inviteCode) return;
            $.ajax({
                type: 'GET',
                url: '{{ env('DISCORD_API_URL') }}/invites/' + inviteCode + '?with_counts=true&with_expiration=true' + ((eventId !== '' && eventId != null) ? '&guild_scheduled_event_id=' + eventId : ''),
                success: (respond) => Livewire.emit('processInviteJson', respond),
                error: () => Livewire.emit('processInviteJson', null),
            });
        }

        var urls = [];
        function downloadEmojis(guildId, urls)
        {
            document.getElementById('buttonDownloadAllEmojis').disabled = true;
            document.getElementById('buttonDownloadAllEmojis').innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('Downloading...') }}';

            // https://gist.github.com/c4software/981661f1f826ad34c2a5dc11070add0f#gistcomment-3372574
            var zip = new JSZip();
            var count = 0;
            var filenameCounter = 0;
            var fileNames = [];
            for (var i = 0; i < urls.length; i++){
                fileNames[i] = urls[i].split('/').pop();
            }
            urls.forEach(function(url){
                var filename = fileNames[filenameCounter];
                filenameCounter++;
                JSZipUtils.getBinaryContent(url, function (err, data) {
                    if(err) throw err;
                    zip.file(filename, data, {binary:true});
                    count++;
                    if (count === urls.length) {
                        zip.generateAsync({type:'blob'}).then(function(content) {
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
