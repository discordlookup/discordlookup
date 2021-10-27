<div id="inviteinfo">

    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Invite Info') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">

            <div wire:ignore class="col-12 col-lg-6 offset-lg-3 mb-5">
                <div class="input-group input-group-lg mb-3">
                    <span class="input-group-text bg-dark">discord.gg/</span>
                    <input type="text" class="form-control" id="inviteUrl" placeholder="ep" value="{{ $inviteCode }}">
                </div>
                <button type="button" onclick="loadInvite();" class="btn btn-primary w-100">{{ __('Fetch Invite Information') }}</button>
            </div>

            <div id="displaysectionLoading" class="d-flex justify-content-center" style="display: none !important;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
            </div>

            <div id="displaysectionContent">
                @if($found)
                    <div class="col-12 col-lg-6 offset-lg-3" @if(empty($guildName))style="display: none;"@endif>
                        <div class="card text-white bg-dark">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0">
                                        <a href="{{ $guildIconUrl }}" target="_blank">
                                            <img class="rounded-circle" loading="lazy" src="{{ $guildIconUrl }}" style="width: 64px; height: 64px;" width="64px" height="64px" alt="guild icon">
                                        </a>
                                    </div>
                                    <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0 mt-3 mt-sm-0 text-center text-lg-start align-self-center">
                                        <b>{{ $guildName }}</b>
                                        @if($guildIsPartnered)<img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="discord badge partner">@endif
                                        @if($guildIsVerified)<img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="discord badge verified">@endif
                                        <div class="small">
                                            <span class="discord-status-pill discord-status-pill-online"></span> {{ number_format($guildOnlineCount, 0, '', '.') }} {{ __('Online') }}
                                            <span class="discord-status-pill discord-status-pill-offline ms-3"></span> {{ number_format($guildMemberCount, 0, '', '.') }} {{ __('Members') }}<br>
                                        </div>
                                    </div>
                                    @if($guildBannerUrl)
                                        <div class="col-auto me-auto ms-auto me-lg-0 mt-3 mt-sm-0">
                                            <a href="{{ $guildBannerUrl }}" target="_blank">
                                                <img src="{{ $guildBannerUrl }}" loading="lazy" class="rounded-3" style="height: 64px;" height="64px" alt="guild banner">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                @if($guildDescription)
                                    {{ $guildDescription }}
                                    <hr>
                                @endif
                                <div>
                                    <b>{{ __('Invite Channel') }}:</b> <a href="https://discord.com/channels/{{ $guildId }}/{{ $inviteChannelId }}" target="_blank" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteChannelId }}">{{ $inviteChannelName }}</a><br>
                                    @if($inviteInviterName)
                                        <b>{{ __('Invite Creator') }}:</b> <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteInviterId }}">
                                            <a href="{{ route('snowflake', ['snowflake' => $inviteInviterId]) }}">{{ $inviteInviterName }}</a>
                                        </span><br>
                                    @endif
                                    <b>{{ __('Invite Expires') }}:</b> {!! $inviteExpiresAtFormatted !!}<br>
                                    <br>
                                    <b>{{ __('Guild ID') }}:</b> <a href="https://discord.com/channels/{{ $guildId }}" target="_blank" class="text-decoration-none">{{ $guildId }}</a><br>
                                    @if($guildVanityUrlCode)
                                        <b>{{ __('Guild Vanity URL') }}:</b> <a href="{{ $guildVanityUrl }}" target="_blank" class="text-decoration-none">{{ $guildVanityUrl }}</a><br>
                                    @endif
                                    <b>{{ __('Guild NSFW') }}:</b> @if($guildIsNSFW) &#10004; @else &#10060; @endif <br>
                                    @if($guildIsNSFW)
                                        <b>{{ __('Guild NSFW Level') }}:</b> {{ $guildIsNSFWLevel }}<br>
                                    @endif
                                    <b>{{ __('Guild Features') }}:</b>
                                    <ul class="text-capitalize">
                                        @foreach($guildFeatures as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12 col-lg-6 offset-lg-3">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ __('The entered Invite could not be found! Try again with another code.') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($inviteCode)
        <script>
            document.addEventListener('livewire:load', function () {
                loadInvite();
            })
        </script>
    @endif

    @push('scripts')
        <script>
            var inputInviteUrl = document.getElementById('inviteUrl');
            inputInviteUrl.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    loadInvite();
                }
            });

            function loadInvite() {

                $('#displaysectionContent').hide();
                $('#displaysectionLoading').show();

                var code = $('#inviteUrl').val();
                code = code.split('/');
                code = code[code.length - 1];
                $('#inviteUrl').val(code);

                $.ajax({
                    type: 'GET',
                    url: 'https://discord.com/api/v9/invites/' + code + '?with_counts=true&with_expiration=true',
                    success: function (respond) {
                        Livewire.emit(
                            'parseJson',
                            respond,
                            moment.utc(respond.expires_at).local().format("YYYY-MM-DD HH:mm:ss") + ' (' +  moment.utc( respond.expires_at ).local().fromNow() + ')'
                        );
                    },
                    error: function (error) {
                        Livewire.emit('parseJson', null, null);
                    }
                });

                window.history.replaceState('', '', '{{ route('inviteinfo') }}/' + code);
            }
        </script>
    @endpush

</div>
