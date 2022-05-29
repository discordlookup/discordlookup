@section('title', __('Guild Lookup'))
@section('description', __('Get detailed information about Discord Guilds with creation date, Invite/Vanity URL, features and emojis.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div id="guildlookup">
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Guild Lookup') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake" wire:keydown.enter="fetchGuild" class="form-control form-control-lg" type="text" placeholder="{{ __('Guild ID') }}">
                </div>
                <small>
                    <a href="{{ route('help') }}#what-is-a-snowflake-and-how-do-i-find-one" target="_blank" class="text-muted text-decoration-none">
                        <i class="far fa-question-circle"></i> <i>{{ __('What is a Snowflake and how do I find one?') }}</i>
                    </a>
                </small>
            </div>

            @if($errorMessage)
                <div class="col-12 col-lg-6 offset-lg-3 mt-3">
                    <div class="alert alert-danger fade show" role="alert">
                        {{ $errorMessage }}
                    </div>
                </div>
            @elseif($snowflakeDate && $snowflakeTimestamp)
                <div class="col-12 col-lg-6 offset-lg-3 mt-3">
                    <div class="card text-white bg-dark">
                        <div class="card-body">
                            <b>{{ __('Date') }}:</b> {{ $snowflakeDate }}<br>
                            <b>{{ __('Relative') }}:</b> <span wire:ignore id="snowflakeRelative"></span><br>
                            <b>{{ __('Unix Timestamp') }}:</b> <a href="{{ route('timestamp', ['timestamp' => round($snowflakeTimestamp / 1000)]) }}" class="text-decoration-none">{{ $snowflakeTimestamp }}</a><br>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12 col-lg-6 offset-lg-3 mb-3 mt-3">
                <hr>
                <button wire:click="fetchGuild" type="submit" class="btn btn-primary w-100 mt-3">{{ __('Fetch Discord Information') }}</button>
            </div>

            @if($rateLimitHit)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="alert alert-danger fade show" role="alert">
                        {{ __('You send too many requests!') }}
                        @auth
                            {{ __('Please try again in :SECONDS seconds.', ['seconds' => $rateLimitAvailableIn ]) }}
                        @endauth
                        @guest
                            {{ __('Please try again in :SECONDS seconds or log in with your Discord account to increase the limit.', ['seconds' => $rateLimitAvailableIn ]) }}
                        @endguest
                    </div>
                </div>
            @endif

            @if($snowflakeDate && empty($guildData))
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="alert alert-danger fade show" role="alert">
                        {{ __('No Discord guild could be found for the entered Snowflake.') }}<br>
                        {{ __('It is possible that the entered guild has disabled the server widget and discovery.') }}<br>
                        {!! __('If you want to search for a :user or :application instead, check out our other tools.', ['user' => '<a href="' . route('userlookup', ['snowflake' => $snowflake]) . '">user</a>', 'application' => '<a href="' . route('applicationlookup', ['snowflake' => $snowflake]) . '">application</a>']) !!}<br>
                        <br>
                        <a href="{{ route('help') }}#why-some-guilds-cant-be-found-by-their-id" target="_blank" class="text-black text-decoration-none">
                            <i class="far fa-question-circle"></i> <i>{{ __('Why some guilds can\'t be found by their ID/Snowflake?') }}</i>
                        </a>
                    </div>
                </div>
            @elseif($guildData)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="card text-white bg-dark">
                        <div class="card-header">
                            <div class="row">
                                @if(array_key_exists('iconUrl', $guildData) && $guildData['iconUrl'])
                                    <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0">
                                        <a href="{{ $guildData['iconUrl'] }}" target="_blank">
                                            <img src="{{ $guildData['iconUrl'] }}" loading="lazy" class="rounded-circle" style="max-width: 64px; max-height: 64px;" alt="guild icon">
                                        </a>
                                    </div>
                                @endif
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0 mt-3 mt-sm-0 text-center text-lg-start align-self-center">
                                    @if(array_key_exists('name', $guildData) && $guildData['name'])
                                        <b>{{ $guildData['name'] }}</b>
                                    @endif

                                    @if(array_key_exists('isPartnered', $guildData) && $guildData['isPartnered'])
                                        <img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="discord partner badge">
                                    @endif

                                    @if(array_key_exists('isVerified', $guildData) && $guildData['isVerified'])
                                        <img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="discord verified badge">
                                    @endif
                                    <div class="small">
                                        <div>
                                            @if(array_key_exists('onlineCount', $guildData) && $guildData['onlineCount'])
                                                <span class="discord-status-pill discord-status-pill-online"></span>
                                                {{ number_format($guildData['onlineCount'], 0, '', '.') }} {{ __('Online') }}
                                            @endif

                                            @if(array_key_exists('memberCount', $guildData) && $guildData['memberCount'])
                                                <span class="discord-status-pill discord-status-pill-offline ms-3"></span>
                                                {{ number_format($guildData['memberCount'], 0, '', '.') }} {{ __('Members') }}
                                            @endif
                                        </div>
                                        @if(array_key_exists('boostCount', $guildData) && $guildData['boostCount'])
                                            <div>
                                                <img src="{{ asset('images/discord/icons/boosts.png') }}" class="discord-badge ms-n1" alt="discord boosts">
                                                {{ number_format($guildData['boostCount'], 0, '', '.') }} {{ __('Boosts') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(array_key_exists('bannerUrl', $guildData) && $guildData['bannerUrl'])
                                    <div class="col-auto me-auto ms-auto me-lg-0 mt-3 mt-sm-0">
                                        <a href="{{ $guildData['bannerUrl'] }}" target="_blank">
                                            <img src="{{ $guildData['bannerUrl'] }}" loading="lazy" class="rounded-3" style="max-height: 64px;" alt="guild banner">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if(array_key_exists('description', $guildData) && $guildData['description'])
                                {{ $guildData['description'] }}
                                <hr>
                            @endif
                            <div>
                                @if(array_key_exists('id', $guildData) && $guildData['id'])
                                    <b>{{ __('ID') }}:</b>
                                    {{ $guildData['id'] }}<br>
                                @endif

                                @if(array_key_exists('instantInviteUrl', $guildData) && $guildData['instantInviteUrl'])
                                    <b>{{ __('Instant Invite URL') }}:</b>
                                    <a href="{{ $guildData['instantInviteUrl'] }}" target="_blank" class="text-decoration-none">{{ $guildData['instantInviteUrl'] }}</a><br>
                                @endif

                                @if(array_key_exists('channelId', $guildData) && $guildData['channelId'])
                                    <b>{{ __('Instant Invite Channel') }}:</b>
                                    <a href="https://discord.com/channels/{{ $guildData['id'] }}/{{ $guildData['channelId'] }}" target="_blank" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $guildData['channelId'] }}">
                                        @if(array_key_exists('channelName', $guildData) && $guildData['channelName'])
                                            {{ $guildData['channelName'] }}
                                        @else
                                            {{ $guildData['channelId'] }}
                                        @endif
                                    </a>
                                    <br>
                                @endif

                                @if(array_key_exists('vanityUrl', $guildData) && $guildData['vanityUrl'])
                                    <b>{{ __('Vanity URL') }}:</b>
                                    <a href="{{ $guildData['vanityUrl'] }}" target="_blank" class="text-decoration-none">{{ $guildData['vanityUrl'] }}</a><br>
                                @endif

                                @if(array_key_exists('isNSFW', $guildData))
                                    <b>{{ __('NSFW') }}:</b>
                                    @if($guildData['isNSFW'])
                                        &#10004;
                                    @else
                                        &#10060;
                                    @endif
                                    <br>
                                    @if(array_key_exists('isNSFWLevel', $guildData) && $guildData['isNSFW'])
                                        <b>{{ __('NSFW Level') }}:</b>
                                        {{ $guildData['isNSFWLevel'] }}<br>
                                    @endif
                                @endif

                                @if(array_key_exists('features', $guildData) && !empty($guildData['features']))
                                    <b>{{ __('Features') }}:</b>
                                    <ul class="text-capitalize">
                                        @foreach($guildData['features'] as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if(array_key_exists('emojis', $guildData) && !empty($guildData['emojis']))
                                    <hr>

                                    <b>{{ __('Emojis') }} ({{ sizeof($guildData['emojis']) }}):</b><br>

                                    <script>
                                        urls = [];
                                    </script>

                                    <div class="row table-responsive mt-3">
                                        <div class="col-12 col-md-6">
                                            <table class="table table-hover shadow-none">
                                                <tbody>
                                                    @foreach($guildData['emojis'] as $emoji)
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
                                                    @foreach($guildData['emojis'] as $emoji)
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

    @if($guildData && array_key_exists('id', $guildData))
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
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="downloadEmojis('{{ $guildData['id'] }}', urls)">{{ __('Confirm') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        @if($snowflakeTimestamp)
            document.addEventListener('DOMContentLoaded', () => updateRelative({{ $snowflakeTimestamp }}));
        @endif
        @if($guildData && array_key_exists('instantInviteUrlCode', $guildData))
            document.addEventListener('DOMContentLoaded', () => getInviteInfo('{{ $guildData['instantInviteUrlCode'] }}'));
        @endif
        window.addEventListener('updateRelative', event => updateRelative(event.detail.timestamp));
        window.addEventListener('getInviteInfo', event => getInviteInfo(event.detail.inviteCode));

        function updateRelative(timestamp) {
            document.getElementById('snowflakeRelative').innerText = moment.utc(timestamp).local().fromNow();
        }

        function getInviteInfo(inviteCode)
        {
            if(!inviteCode) return;
            $.ajax({
                type: 'GET',
                url: '{{ env('DISCORD_API_URL') }}/invites/' + inviteCode + '?with_counts=true&with_expiration=true',
                success: (respond) => Livewire.emit('processInviteJson', respond),
                error: () => Livewire.emit('processInviteJson', null),
            });
        }
    </script>

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
