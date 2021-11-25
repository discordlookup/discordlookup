<div id="inviteresolver">

    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Invite Resolver') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">

            <div wire:ignore class="col-12 col-lg-6 offset-lg-3 mb-5">
                <div class="input-group input-group-lg mb-2">
                    <span class="input-group-text bg-dark">discord.gg/</span>
                    <input id="inviteUrl" type="text" class="form-control" placeholder="ep" value="{{ $inviteCode }}">
                </div>
                <input id="inviteEventId" class="form-control mb-3" type="text" placeholder="{{ __('Event ID') }}" value="{{ $eventId }}">
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
                                    <b>{{ __('Invite Channel') }}:</b> <a href="https://discord.com/channels/{{ $guildId }}/{{ $inviteChannelId }}" target="_blank" rel="noopener" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteChannelId }}">{{ $inviteChannelName }}</a><br>
                                    @if($inviteInviterName)
                                        <b>{{ __('Invite Creator') }}:</b> <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteInviterId }}">
                                            <a href="{{ route('userlookup', ['snowflake' => $inviteInviterId]) }}">{{ $inviteInviterName }}</a>
                                        </span><br>
                                    @endif
                                    <b>{{ __('Invite Expires') }}:</b> <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inviteExpiresAt }}">{!! $inviteExpiresAtFormatted !!}</span><br>
                                    <hr>
                                    <b>{{ __('Guild ID') }}:</b> <a href="{{ route('guildlookup') }}/{{ $guildId }}" class="text-decoration-none">{{ $guildId }}</a><br>
                                    @if($guildVanityUrlCode)
                                        <b>{{ __('Guild Vanity URL') }}:</b> <a href="{{ $guildVanityUrl }}" target="_blank" class="text-decoration-none">{{ $guildVanityUrl }}</a><br>
                                    @endif
                                    <b>{{ __('Guild NSFW') }}:</b> @if($guildIsNSFW) &#10004; @else &#10060; @endif <br>
                                    @if($guildIsNSFW)
                                        <b>{{ __('Guild NSFW Level') }}:</b> {{ $guildIsNSFWLevel }}<br>
                                    @endif
                                    @if(!empty($guildFeatures))
                                        <b>{{ __('Guild Features') }}:</b>
                                        <ul class="text-capitalize">
                                            @foreach($guildFeatures as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($inviteHasEvent)
                                        <hr>
                                        <b>{{ __('Event ID') }}:</b> {{ $eventId }}<br>
                                        @if($eventChannelId)
                                            <b>{{ __('Channel ID') }}:</b> <a href="https://discord.com/channels/{{ $guildId }}/{{ $eventChannelId }}" target="_blank" rel="noopener" class="text-decoration-none">{{ $eventChannelId }}</a><br>
                                        @endif
                                        @if($eventCreatorId)
                                            <b>{{ __('Creator ID') }}:</b> <a href="{{ route('userlookup', ['snowflake' => $eventCreatorId]) }}" class="text-decoration-none">{{ $eventCreatorId }}</a><br>
                                        @endif
                                        <b>{{ __('Name') }}:</b> {{ $eventName }}<br>
                                        @if($eventDescription)
                                            <b>{{ __('Description') }}:</b> {{ $eventDescription }}<br>
                                        @endif
                                        <b>{{ __('Start') }}:</b> <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $eventStartTime }}">{!! $eventStartFormatted !!}</span><br>
                                        @if($eventEndTime)
                                            <b>{{ __('End') }}:</b> <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $eventEndTime }}">{!! $eventEndFormatted !!}</span><br>
                                        @endif
                                        <b>{{ __('Privacy Level') }}:</b> <span class="badge bg-body">{{ $eventPrivacyLevel }}</span><br>
                                        <b>{{ __('Status') }}:</b> {!! $eventStatus !!}<br>
                                        <b>{{ __('Entity Type') }}:</b> <span class="badge bg-body">{{ $eventEntityType }}</span><br>
                                        @if($eventEntityId)
                                            <b>{{ __('Entity ID') }}:</b> {{ $eventEntityId }}<br>
                                        @endif
                                        @if($eventEntityMetadataLocation)
                                            <b>{{ __('Entity Location') }}:</b> <a href="{{ $eventEntityMetadataLocation }}" target="_blank" rel="noopener" class="text-decoration-none">{{ $eventEntityMetadataLocation }}</a><br>
                                        @endif
                                        @if($eventUserCount)
                                            <b>{{ __('Interested users') }}:</b> {{ $eventUserCount }}<br>
                                        @endif
                                    @endif
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
            document.addEventListener("DOMContentLoaded", () => {
                $(function () {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                })

                Livewire.hook('message.processed', (message, component) => {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip()
                    })
                })
            });

            var inputInviteUrl = document.getElementById('inviteUrl');
            inputInviteUrl.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    loadInvite();
                }
            });

            function loadInvite() {

                $('#displaysectionContent').hide();
                $('#displaysectionLoading').show();

                var inviteUrl = document.getElementById("inviteUrl").value;
                var eventId = document.getElementById("inviteEventId").value;
                inviteUrl = inviteUrl.split('?event=');

                var inviteCode = inviteUrl[0].split('/');
                inviteCode = inviteCode[inviteCode.length - 1];

                if(inviteUrl.length > 1) {
                    eventId = inviteUrl[1];
                }

                document.getElementById("inviteUrl").value = inviteCode;
                document.getElementById("inviteEventId").value = eventId;

                $.ajax({
                    type: 'GET',
                    url: 'https://discord.com/api/v9/invites/' + inviteCode + '?with_counts=true&with_expiration=true' + (eventId !== "" ? '&guild_scheduled_event_id=' + eventId : ''),
                    success: function (respond) {
                        let inviteExpiresAt = moment.utc(respond.expires_at).local().format("YYYY-MM-DD HH:mm:ss") + ' (' +  moment.utc( respond.expires_at ).local().fromNow() + ')';
                        let eventStart = "";
                        let eventEnd = "";
                        if(respond.guild_scheduled_event != null) {
                            if(respond.guild_scheduled_event.scheduled_start_time != null) {
                                eventStart = moment.utc(respond.guild_scheduled_event.scheduled_start_time).local().format("YYYY-MM-DD HH:mm:ss") + ' (' +  moment.utc( respond.guild_scheduled_event.scheduled_start_time ).local().fromNow() + ')';
                            }
                            if(respond.guild_scheduled_event.scheduled_end_time != null) {
                                eventEnd = moment.utc(respond.guild_scheduled_event.scheduled_end_time).local().format("YYYY-MM-DD HH:mm:ss") + ' (' +  moment.utc( respond.guild_scheduled_event.scheduled_end_time ).local().fromNow() + ')';
                            }
                        }

                        Livewire.emit('parseJson', respond, inviteExpiresAt, eventStart, eventEnd);
                    },
                    error: function (error) {
                        Livewire.emit('parseJson', null, null, null, null);
                    }
                });

                window.history.replaceState('', '', '{{ route('inviteresolver') }}/' + inviteCode + (eventId !== "" ? '/' + eventId : ''));
            }
        </script>
    @endpush

</div>
