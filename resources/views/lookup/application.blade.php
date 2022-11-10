@section('title', __('Application Lookup'))
@section('description', __('Get detailed information about Discord applications with description, links, tags and flags.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div class="applicationlookup">
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Application Lookup') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake" wire:keydown.enter="fetchApplication" class="form-control form-control-lg" type="text" placeholder="{{ __('Application ID') }}">
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
                <button wire:click="fetchApplication" type="submit" class="btn btn-primary w-100 mt-3">{{ __('Fetch Discord Information') }}</button>
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

            @if($applicationData == null && $snowflakeDate)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="alert alert-danger fade show" role="alert">
                        {{ __('No Discord application could be found for the entered Snowflake.') }}<br>
                        {!! __('If you want to search for a :guild or :user instead, check out our other tools.', ['guild' => '<a href="' . route('guildlookup', ['snowflake' => $snowflake]) . '">guild</a>', 'user' => '<a href="' . route('userlookup', ['snowflake' => $snowflake]) . '">user</a>']) !!}<br>
                    </div>
                </div>
            @elseif($applicationData)
                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="card text-white bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0">
                                    <a href="{{ $applicationData['iconUrl'] }}" target="_blank">
                                        <img src="{{ $applicationData['iconUrl'] }}" loading="lazy" class="rounded-circle" style="width: 64px; height: 64px;" width="64px" height="64px" alt="app icon">
                                    </a>
                                </div>
                                <div class="col-auto me-auto ms-auto me-lg-0 ms-lg-0 text-center text-lg-start align-self-center">
                                    <b>{{ $applicationData['name'] }}</b>
                                    <div class="small text-muted">{{ $applicationData['id'] }}</div>
                                </div>
                                @if($applicationData['coverImageUrl'])
                                    <div class="col-auto me-auto ms-auto me-lg-0 mt-3 mt-sm-0">
                                        <a href="{{ $applicationData['coverImageUrl'] }}" target="_blank">
                                            <img src="{{ $applicationData['coverImageUrl'] }}" loading="lazy" class="rounded-3" style="height: 64px;" height="64px" alt="cover image">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if($applicationData['descriptionFormatted'])
                                {!! $applicationData['descriptionFormatted'] !!}
                                <hr>
                            @endif
                            <div>
                                <b>{{ __('Application Created') }}:</b>
                                {{ $snowflakeDate }}
                                <br>

                                @if($applicationData['summary'])
                                    <b>{{ __('Summary') }}:</b>
                                    {{ $applicationData['summary'] }}
                                    <br>
                                @endif

                                @if($applicationData['guildId'])
                                    <b>{{ __('Linked Guild') }}:</b>
                                    <a href="{{ route('guildlookup', ['snowflake' => $applicationData['guildId']]) }}">{{ $applicationData['guildId'] }}</a>
                                    <br>
                                @endif

                                @if(!is_null($applicationData['type']))
                                    <b>{{ __('Type') }}:</b>
                                    {{ $applicationData['type'] }}
                                    <br>
                                @endif

                                @if(!is_null($applicationData['hook']))
                                    <b>{{ __('Hook') }}:</b>
                                    @if($applicationData['hook'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="discord-badge" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="discord-badge" alt="Cross">
                                    @endif
                                    <br>
                                @endif

                                @if(!is_null($applicationData['botPublic']))
                                    <b>{{ __('Public Bot') }}:</b>
                                    @if($applicationData['botPublic'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="discord-badge" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="discord-badge" alt="Cross">
                                    @endif
                                    <br>
                                @endif

                                @if(!is_null($applicationData['botRequireCodeGrant']))
                                    <b>{{ __('Requires OAuth2 Code Grant') }}:</b>
                                    @if($applicationData['botRequireCodeGrant'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="discord-badge" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="discord-badge" alt="Cross">
                                    @endif
                                    <br>
                                @endif

                                @if($applicationData['customInstallUrl'] || $applicationData['termsOfServiceUrl'] || $applicationData['privacyPolicyUrl'])
                                    <b>{{ __('Links') }}:</b>
                                    <ul>
                                        @if($applicationData['customInstallUrl'])
                                            <li>
                                                <a href="{{ $applicationData['customInstallUrl'] }}" target="_blank" rel="noopener">{{ __('Custom Install Url') }}</a>
                                            </li>
                                        @endif
                                        @if($applicationData['termsOfServiceUrl'])
                                            <li>
                                                <a href="{{ $applicationData['termsOfServiceUrl'] }}" target="_blank" rel="noopener">{{ __('Terms of Service') }}</a>
                                            </li>
                                        @endif
                                        @if($applicationData['privacyPolicyUrl'])
                                            <li>
                                                <a href="{{ $applicationData['privacyPolicyUrl'] }}" target="_blank" rel="noopener">{{ __('Privacy Policy') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                @endif

                                @if(!empty($applicationData['tags']))
                                    <b>{{ __('Tags') }}:</b>
                                    <ul>
                                        @foreach($applicationData['tags'] as $tag)
                                            <li>
                                                {{ $tag }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if(!empty($applicationData['flagsList']))
                                    <b>{{ __('Flags') }}:</b>
                                    <ul style="list-style-type: none;">
                                        @foreach($applicationData['flagsList'] as $flag)
                                            <li style="margin-left: -1rem; text-transform: capitalize;">
                                                {{ str_replace('_', ' ', strtolower($flag)) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <a role="button" href="{{ route('userlookup', $applicationData['id']) }}" class="btn btn-primary w-100 mt-3">{{ __('More information about this bot') }}</a>
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
