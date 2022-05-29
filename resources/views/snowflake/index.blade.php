@section('title', __('Snowflake Decoder'))
@section('description', __('Get the creation date of a Snoflake, and detailed information about Discord users, guilds and applications.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div id="snowflakedecoder">
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Snowflake Decoder') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake" class="form-control form-control-lg" type="text" placeholder="{{ __('Snowflake') }}">
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
                            <b>{{ __('Relative') }}:</b> <span id="snowflakeRelative"></span><br>
                            <b>{{ __('Unix Timestamp') }}:</b> <a href="{{ route('timestamp', ['timestamp' => round($snowflakeTimestamp / 1000)]) }}" class="text-decoration-none">{{ $snowflakeTimestamp }}</a><br>
                            <span class="small fst-italic">
                                <a href="{{ route('snowflake-distance-calculator', ['snowflake1' => $snowflake]) }}" class="text-decoration-none">
                                    {{ __('Click here to go to the Snowflake Distance Calculator') }}
                                </a>
                            </span>
                        </div>
                    </div>
                    <a role="button" href="{{ route('userlookup') }}/{{ $snowflake }}" class="btn btn-primary w-100 mt-5">{{ __('Lookup User') }}</a>
                    <a role="button" href="{{ route('guildlookup') }}/{{ $snowflake }}" class="btn btn-primary w-100 mt-3">{{ __('Lookup Guild') }}</a>
                    {{--<a role="button" href="{{ route('applicationlookup') }}/{{ $snowflake }}" class="btn btn-primary w-100 mt-3">{{ __('Lookup Application') }}</a>--}}
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
