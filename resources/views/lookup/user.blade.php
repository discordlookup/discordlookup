@section('title', __('User Lookup'))
@section('description', __('Get detailed information about Discord users with creation date, profile picture, banner and badges.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div id="userlookup">
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('User Lookup') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake" wire:keydown.enter="fetchUser" class="form-control form-control-lg" type="text" placeholder="{{ __('User ID') }}">
                </div>
                <div class="small">
                    <a href="{{ route('help') }}#what-is-a-snowflake-and-how-do-i-find-one" target="_blank" class="text-muted text-decoration-none">
                        <i class="far fa-question-circle"></i> <i>{{ __('What is a Snowflake and how do I find one?') }}</i>
                    </a>
                </div>
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
                <button wire:click="fetchUser" type="submit" class="btn btn-primary w-100 mt-3">{{ __('Fetch Discord Information') }}</button>
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

            @if($userData == null && $snowflakeDate)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="alert alert-danger fade show" role="alert">
                        {{ __('No Discord user could be found for the entered Snowflake.') }}<br>
                        {!! __('If you want to search for a :guild or :application instead, check out our other tools.', ['guild' => '<a href="' . route('guildlookup', ['snowflake' => $snowflake]) . '">guild</a>', 'application' => '<a href="' . route('applicationlookup', ['snowflake' => $snowflake]) . '">application</a>']) !!}<br>
                    </div>
                </div>
            @elseif($userData)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="card text-white bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0">
                                    <a href="{{ $userData['avatarUrl'] }}" target="_blank">
                                        <img src="{{ $userData['avatarUrl'] }}" loading="lazy" class="rounded-circle" style="width: 64px; height: 64px;" width="64px" height="64px" alt="user avatar">
                                    </a>
                                </div>
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0 text-center text-lg-start align-self-center">
                                    <b>{{ $userData['username'] }}<span class="small text-muted">#{{ $userData['discriminator'] }}</span></b>
                                    @if($userData['isBot'])
                                        <span class="badge" style="color: #fff; background-color: #5865f2; top: -1px; position: relative;">
                                            @if($userData['isVerifiedBot'])
                                                <i class="fas fa-check"></i>&nbsp;
                                            @endif
                                            <span class="text-uppercase">{{ __('Bot') }}</span>
                                        </span>
                                    @endif
                                    <div class="small text-muted">{{ $userData['id'] }}</div>
                                </div>
                                @if($userData['bannerUrl'])
                                    <div class="col-auto me-auto ms-auto me-lg-0 mt-3 mt-sm-0">
                                        <a href="{{ $userData['bannerUrl'] }}" target="_blank">
                                            <img src="{{ $userData['bannerUrl'] }}" loading="lazy" class="rounded-3" style="height: 64px;" height="64px" alt="user banner">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <b>{{ __('Account Created') }}:</b>
                                {{ $snowflakeDate }}
                                <br>

                                <b>{{ __('Bot') }}:</b>
                                @if($userData['isBot'])
                                    <img src="{{ asset('images/discord/icons/check.svg') }}" class="discord-badge" alt="Check">
                                @else
                                    <img src="{{ asset('images/discord/icons/cross.svg') }}" class="discord-badge" alt="Cross">
                                @endif
                                <br>

                                @if($userData['isBot'])
                                    <b>{{ __('Verified Bot') }}:</b>
                                    @if($userData['isVerifiedBot'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="discord-badge" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="discord-badge" alt="Cross">
                                    @endif
                                    <br>
                                @endif

                                @if($userData['bannerColor'])
                                    <b>{{ __('Banner Color') }}:</b>
                                    <span style="background-color: {{ $userData['bannerColor'] }};">{{ $userData['bannerColor'] }}</span><br>
                                @endif

                                @if($userData['accentColor'])
                                    <b>{{ __('Accent Color') }}:</b>
                                    <span style="background-color: {{ $userData['accentColor'] }};">{{ $userData['accentColor'] }}</span><br>
                                @endif

                                @if(!empty($userData['flagsList']))
                                    <b>{{ __('Badges') }}:</b>
                                    <ul style="list-style-type: none;">
                                        @foreach($userData['flagsList'] as $flag)
                                            <li style="margin-left: -1rem;">
                                                @if($flag['image'])
                                                    <img src="{{ $flag['image'] }}" loading="lazy" height="18" width="18" alt="{{ $flag['name'] }} badge icon"> {{ $flag['name'] }}
                                                @else
                                                    {{ $flag['name'] }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                {{-- TODO: top.gg API fetch for bots? --}}
                            </div>
                        </div>
                    </div>
                    @if($userData['isBot'])
                        <a role="button" href="{{ route('applicationlookup', $userData['id']) }}" class="btn btn-primary w-100 mt-3">{{ __('More information about this application') }}</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        @if($snowflakeTimestamp)
            document.addEventListener('DOMContentLoaded', () => updateRelative({{ $snowflakeTimestamp }}));
        @endif
        window.addEventListener('updateRelative', event => updateRelative(event.detail.timestamp));

        function updateRelative(timestamp) {
            document.getElementById('snowflakeRelative').innerText = moment.utc(timestamp).local().fromNow();
        }
    </script>
</div>
