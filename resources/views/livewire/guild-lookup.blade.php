@section('og.sitename', $ogSiteName)
@section('og.title', $ogTitle)
@section('og.image', $ogImage)
@section('og.description', $ogDescription)

<div id="guildlookup">

    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Guild Lookup') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">

            <div class="col-12 col-lg-6 offset-lg-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake" id="snowflakeInput" oninput="updateSnowflake(this.value);" onchange="updateSnowflake(this.value);" onkeyup="updateSnowflake(this.value);" class="form-control form-control-lg" type="text" placeholder="{{ __('Guild ID') }}">
                </div>
                <small>
                    <a href="{{ route('help') }}#what-is-a-snowflake-and-how-do-i-find-one" target="_blank" class="text-muted text-decoration-none">
                        <i class="far fa-question-circle"></i> <i>{{ __('What is a Snowflake and how do I find one?') }}</i>
                    </a>
                </small>
            </div>

            <div wire:ignore id="invalidSnowflake" class="col-12 col-lg-6 offset-lg-3 mt-3" style="display: none;">
                <div id="invalidSnowflakeMessage" class="alert alert-danger fade show" role="alert"></div>
            </div>

            <div wire:ignore id="validSnowflake" class="col-12 col-lg-6 offset-lg-3 mt-3" style="display: none;">
                <div class="card text-white bg-dark">
                    <div class="card-body">
                        <b>{{ __('Date') }}:</b> <span id="snowflakeDate"></span><br>
                        <b>{{ __('Relative') }}:</b> <span id="snowflakeRelative"></span><br>
                        <b>{{ __('Unix Timestamp') }}:</b> <span id="snowflakeUnix"></span><br>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 offset-lg-3 mb-3 mt-3">
                <hr>
                <button wire:click="fetchSnowflake" onclick="hideSections();" type="submit" class="btn btn-primary w-100 mt-3">{{ __('Fetch Discord Information') }}</button>
            </div>

            <div id="displaysectionLoading" class="d-flex justify-content-center" style="display: none !important;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
            </div>

            @if(!$isLoggedIn)
                <div id="displaysectionLogin" class="col-12 col-lg-6 offset-lg-3">
                    <div class="alert alert-info fade show text-center" role="alert">
                        {{ __('To get Discord information about this Snowflake you need to log in with Discord.') }}<br>
                        <a role="button" class="btn btn-info mt-3" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                    </div>
                </div>
            @endif

            @if($rateLimitHit)
                <div id="displaysectionRatelimit" class="col-12 col-lg-6 offset-lg-3">
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

            @if($template == "notfound")
                <div id="displaysectionNotfound" class="col-12 col-lg-6 offset-lg-3">
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
            @endif

            <div id="displaysectionContent" class="col-12 col-lg-6 offset-lg-3" @if(!$found)style="display: none;"@endif>
                @if($template == "guild")
                    <div class="card text-white bg-dark" @if(empty($guildName))style="display: none;"@endif>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0">
                                    <a href="{{ $guildIconUrl }}" target="_blank">
                                        <img src="{{ $guildIconUrl }}" loading="lazy" class="rounded-circle" style="max-width: 64px; max-height: 64px;" alt="guild icon">
                                    </a>
                                </div>
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0 mt-3 mt-sm-0 text-center text-lg-start align-self-center">
                                    <b>{{ $guildName }}</b>
                                    @if($guildIsPartnered)<img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="discord partner badge">@endif
                                    @if($guildIsVerified)<img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="discord verified badge">@endif
                                    <div class="small">
                                        @if($guildOnlineCount != null)
                                            <span class="discord-status-pill discord-status-pill-online"></span> {{ number_format($guildOnlineCount, 0, '', '.') }} {{ __('Online') }}
                                        @endif
                                        @if($guildMemberCount != null)
                                            <span class="discord-status-pill discord-status-pill-offline ms-3"></span> {{ number_format($guildMemberCount, 0, '', '.') }} {{ __('Members') }}<br>
                                        @endif
                                    </div>
                                </div>
                                @if($guildBannerUrl)
                                    <div class="col-auto me-auto ms-auto me-lg-0 mt-3 mt-sm-0">
                                        <a href="{{ $guildBannerUrl }}" target="_blank">
                                            <img src="{{ $guildBannerUrl }}" loading="lazy" class="rounded-3" style="max-height: 64px;" alt="guild banner">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($guildDescription || $inviteChannelId || $guildInstantInvite || $guildVanityUrlCode || $guildIsNSFW || !empty($guildFeatures) || !empty($guildEmojis))
                            <div class="card-body">
                                @if($guildDescription)
                                    {{ $guildDescription }}
                                    <hr>
                                @endif
                                <div>
                                    @if($inviteChannelId)
                                        <b>{{ __('Invite Channel') }}:</b> <a href="https://discord.com/channels/{{ $guildId }}/{{ $inviteChannelId }}" target="_blank" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteChannelId }}">{{ $inviteChannelName }}</a><br>
                                        <br>
                                    @endif
                                    @if($guildInstantInvite)
                                        <b>{{ __('Guild Invite URL') }}:</b> <a href="https://discord.gg/{{ $guildInstantInvite }}" target="_blank" class="text-decoration-none">https://discord.gg/{{ $guildInstantInvite }}</a><br>
                                    @endif
                                    @if($guildVanityUrlCode)
                                        <b>{{ __('Guild Vanity URL') }}:</b> <a href="{{ $guildVanityUrl }}" target="_blank" class="text-decoration-none">{{ $guildVanityUrl }}</a><br>
                                    @endif
                                    @if($guildIsNSFW != null)
                                        <b>{{ __('Guild NSFW') }}:</b> @if($guildIsNSFW) &#10004; @else &#10060; @endif <br>
                                        @if($guildIsNSFW)
                                            <b>{{ __('Guild NSFW Level') }}:</b> {{ $guildIsNSFWLevel }}<br>
                                        @endif
                                    @endif
                                    @if(!empty($guildFeatures))
                                        <b>{{ __('Guild Features') }}:</b>
                                        <ul class="text-capitalize">
                                            @foreach($guildFeatures as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if(!empty($guildEmojis))

                                        <b>{{ __('Guild Emojis') }} ({{ sizeof($guildEmojis) }}):</b><br>

                                        <script>
                                            urls = [];
                                        </script>

                                        <div class="row table-responsive">
                                            <div class="col-12 col-md-6">
                                                <table class="table table-hover shadow-none">
                                                    <tr>
                                                        <th>{{ __('Preview') }}</th>
                                                        <th>{{ __('Name') }}</th>
                                                        <th></th>
                                                    </tr>
                                                    @foreach($guildEmojis as $emoji)
                                                        <script>
                                                            urls.push('https://cdn.discordapp.com/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}');
                                                        </script>
                                                        @if($loop->odd)
                                                            <tr>
                                                                <td>
                                                                    <a href="https://cdn.discordapp.com/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}" target="_blank" class="text-decoration-none">
                                                                        <img src="https://cdn.discordapp.com/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}?size=32" loading="lazy" style="max-height: 32px; max-width: 32px;" alt="{{ $emoji['name'] }} emoji" title="{{ $emoji['name'] }}">
                                                                    </a>
                                                                </td>
                                                                <td>{{ $emoji['name'] }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <table class="table table-hover shadow-none">
                                                    <tr>
                                                        <th>{{ __('Preview') }}</th>
                                                        <th>{{ __('Name') }}</th>
                                                    </tr>
                                                    @foreach($guildEmojis as $emoji)
                                                        @if($loop->even)
                                                            <tr>
                                                                <td>
                                                                    <a href="https://cdn.discordapp.com/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}" target="_blank" class="text-decoration-none">
                                                                        <img src="https://cdn.discordapp.com/emojis/{{ $emoji['id'] }}{{ $emoji['animated'] ? '.gif' : '.png' }}?size=32" loading="lazy" style="max-height: 32px; max-width: 32px;" alt="{{ $emoji['name'] }} emoji" title="{{ $emoji['name'] }}">
                                                                    </a>
                                                                </td>
                                                                <td>{{ $emoji['name'] }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
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
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Download Emojis Modal -->
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
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="downloadEmojis('{{ $guildId }}', urls)">{{ __('Confirm') }}</button>
                </div>
            </div>
        </div>
    </div>

    @if($snowflake)
        <script>
            document.addEventListener('livewire:load', function () {
                updateSnowflake("{{ $snowflake }}");
                Livewire.emit('fetchSnowflake');
                hideSections();
            })
        </script>
    @endif

    @push('scripts')
        <script>

            window.addEventListener('contentChanged', event => {
                if(event.detail.invitecode !== "") {
                    $.ajax({
                        type: 'GET',
                        url: 'https://discord.com/api/v9/invites/' + event.detail.invitecode + '?with_counts=true&with_expiration=false',
                        success: function (respond) {
                            Livewire.emit('parseInviteJson', respond);
                        }
                    });
                }
            });

            function hideSections() {
                $('#displaysectionLoading').show();
                $('#displaysectionLogin').hide();
                $('#displaysectionRatelimit').hide();
                $('#displaysectionNotfound').hide();
                $('#displaysectionContent').hide();
            }

            function updateSnowflake(value) {

                window.history.replaceState('', '', '{{ route('guildlookup') }}');

                if(value.length > 0) {
                    var date = validateSnowflake(value);
                    if (date.toString().startsWith("That")) {
                        $('#validSnowflake').hide();
                        $('#invalidSnowflake').show();
                        document.getElementById('invalidSnowflakeMessage').innerText = date;
                    } else {
                        $('#invalidSnowflake').hide();
                        $('#validSnowflake').show();
                        document.getElementById('snowflakeDate').innerText = date;
                        document.getElementById('snowflakeRelative').innerText = moment.utc(date).local().fromNow();
                        document.getElementById('snowflakeUnix').innerText = date.getTime();
                        window.history.replaceState('', '', '{{ route('guildlookup') }}/' + value);
                    }
                }else{
                    $('#validSnowflake').hide();
                    $('#invalidSnowflake').hide();
                }
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
                                saveAs(content, "emojis_" + guildId + ".zip");
                                document.getElementById('buttonDownloadAllEmojis').disabled = false;
                                document.getElementById('buttonDownloadAllEmojis').innerHTML = '<i class="fas fa-download"></i> {{ __('Download all Guild Emojis') }}';
                            });
                        }
                    });
                });
            }
        </script>
    @endpush

</div>
