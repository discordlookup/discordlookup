@section('og.sitename', $ogSiteName)
@section('og.title', $ogTitle)
@section('og.image', $ogImage)
@section('og.description', $ogDescription)
@section('themecolor', $userBannerColor)

<div id="userlookup">

    <h1 class="mb-4 mt-5 text-center text-white">{{ __('User Lookup') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">

            <div class="col-12 col-lg-6 offset-lg-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake" id="snowflakeInput" oninput="updateSnowflake(this.value);" onchange="updateSnowflake(this.value);" onkeyup="updateSnowflake(this.value);" class="form-control form-control-lg" type="text" placeholder="{{ __('User ID') }}">
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
                        {{ __('No Discord user could be found for the entered Snowflake.') }}<br>
                        {!! __('If you want to search for a :guild or :application instead, check out our other tools.', ['guild' => '<a href="' . route('guildlookup', ['snowflake' => $snowflake]) . '">guild</a>', 'application' => '<a href="' . route('applicationlookup', ['snowflake' => $snowflake]) . '">application</a>']) !!}<br>
                    </div>
                </div>
            @endif

            <div id="displaysectionContent" class="col-12 col-lg-6 offset-lg-3" @if(!$found)style="display: none;"@endif>
                @if($template == "user")
                    <div class="card text-white bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0">
                                    <a href="{{ $userAvatarUrl }}" target="_blank">
                                        <img src="{{ $userAvatarUrl }}" loading="lazy" class="rounded-circle" style="width: 64px; height: 64px;" width="64px" height="64px" alt="user avatar">
                                    </a>
                                </div>
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0 text-center text-lg-start align-self-center">
                                    <b>{{ $userUsername }}<small class="text-muted">#{{ $userDiscriminator }}</small></b>
                                    @if($userIsBot)
                                        <span class="badge" style="color: #fff; background-color: #5865f2; top: -1px; position: relative;">
                                            @if($userIsVerifiedBot)
                                                <i class="fas fa-check"></i>&nbsp;
                                            @endif
                                            <span class="text-uppercase">{{ __('Bot') }}</span>
                                        </span>
                                    @endif
                                    <div class="small text-muted">{{ $userId }}</div>
                                </div>
                                @if($userBannerUrl)
                                    <div class="col-auto me-auto ms-auto me-lg-0 mt-3 mt-sm-0">
                                        <a href="{{ $userBannerUrl }}" target="_blank">
                                            <img src="{{ $userBannerUrl }}" loading="lazy" class="rounded-3" style="height: 64px;" height="64px" alt="user banner">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if($userAboutMe)
                                {{ $userAboutMe }}
                                <hr>
                            @endif
                            <div>
                                <b>{{ __('Account Created') }}:</b> <span wire:ignore id="accountCreated"></span><br>
                                <b>{{ __('Bot') }}:</b> @if($userIsBot) &#10004; @else &#10060; @endif <br>
                                @if($userIsBot)
                                    <b>{{ __('Verified Bot') }}:</b> @if($userIsVerifiedBot) &#10004; @else &#10060; @endif <br>
                                @endif
                                @if($userBannerColor)
                                    <b>{{ __('Banner Color') }}:</b> <span style="background-color: {{ $userBannerColor }};">{{ $userBannerColor }}</span><br>
                                @endif
                                @if($userAccentColor)
                                    <b>{{ __('Accent Color') }}:</b> <span style="background-color: {{ $userAccentColor }};">{{ $userAccentColor }}</span><br>
                                @endif
                                @if(!empty($userFlagList))
                                    <b>{{ __('Badges') }}:</b>
                                    <ul style="list-style-type: none;">
                                        @foreach($userFlagList as $flag)
                                            <li style="margin-left: -1rem;">
                                                <img src="{{ $flag['image'] }}" loading="lazy" style="max-height: 16px; max-width: 16px;" alt="{{ $flag['name'] }} badge icon"> {{ $flag['name'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                {{-- TODO: top.gg API fetch for bots? --}}
                            </div>
                        </div>
                    </div>
                @endif
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
                var accountCreatedSpan = document.getElementById('accountCreated');
                if(accountCreatedSpan != null) {
                    accountCreatedSpan.innerText = validateSnowflake(event.detail.snowflake);
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

                window.history.replaceState('', '', '{{ route('userlookup') }}');

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
                        window.history.replaceState('', '', '{{ route('userlookup') }}/' + value);
                    }
                }else{
                    $('#validSnowflake').hide();
                    $('#invalidSnowflake').hide();
                }
            }
        </script>
    @endpush

</div>
