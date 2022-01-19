@extends('layouts.app')

@section('title', __('Snowflake Decoder'))
@section('description', __('Get the creation date of a Snoflake, and detailed information about Discord users, guilds and applications.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container" id="snowflakedecoder">

        <h1 class="mb-4 mt-5 text-center text-white">{{ __('Snowflake Decoder') }}</h1>
        <div class="mt-2 mb-4">
            <div class="row">

                <div class="col-12 col-lg-6 offset-lg-3">
                    <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                        <input oninput="updateSnowflake(this.value);" onchange="updateSnowflake(this.value);" onkeyup="updateSnowflake(this.value);" class="form-control form-control-lg" type="text" placeholder="{{ __('Snowflake') }}" value="{{ $snowflake }}">
                    </div>
                    <small>
                        <a href="{{ route('help') }}#what-is-a-snowflake-and-how-do-i-find-one" target="_blank" class="text-muted text-decoration-none">
                            <i class="far fa-question-circle"></i> <i>{{ __('What is a Snowflake and how do I find one?') }}</i>
                        </a>
                    </small>
                </div>

                <div id="invalidSnowflake" class="col-12 col-lg-6 offset-lg-3 mt-3" style="display: none;">
                    <div id="invalidSnowflakeMessage" class="alert alert-danger fade show" role="alert"></div>
                </div>

                <div id="validSnowflake" class="col-12 col-lg-6 offset-lg-3 mt-3" style="display: none;">
                    <div class="card text-white bg-dark">
                        <div class="card-body">
                            <b>{{ __('Date') }}:</b> <span id="snowflakeDate"></span><br>
                            <b>{{ __('Relative') }}:</b> <span id="snowflakeRelative"></span><br>
                            <b>{{ __('Unix Timestamp') }}:</b> <span id="snowflakeUnix"></span><br>
                            <small><i><a id="snowflakeDistanceCalculatorUrl" href="{{ route('snowflake-distance-calculator', ['snowflake1' => $snowflake]) }}" class="text-decoration-none">{{ __('Click here to go to the Snowflake Distance Calculator') }}</a></i></small>
                        </div>
                    </div>

                    <a id="buttonUser" role="button" href="{{ route('userlookup') }}" class="btn btn-primary w-100 mt-5">{{ __('Lookup User') }}</a>
                    <a id="buttonGuild" role="button" href="{{ route('guildlookup') }}" class="btn btn-primary w-100 mt-3">{{ __('Lookup Guild') }}</a>
                    {{--<a id="buttonApplication" role="button" href="{{ route('applicationlookup') }}" class="btn btn-primary w-100 mt-3">{{ __('Lookup Application') }}</a>--}}

                </div>

            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                updateSnowflake('{{ $snowflake }}');
            });

            function updateSnowflake(value) {

                window.history.replaceState('', '', '{{ route('snowflake') }}');

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
                        document.getElementById('snowflakeDistanceCalculatorUrl').href = "{{ route('snowflake-distance-calculator') }}/" + value;
                        document.getElementById('buttonUser').href = "{{ route('userlookup') }}/" + value;
                        document.getElementById('buttonGuild').href = "{{ route('guildlookup') }}/" + value;
                        {{--document.getElementById('buttonApplication').href = "{{ route('applicationlookup') }}/" + value;--}}
                        window.history.replaceState('', '', '{{ route('snowflake') }}/' + value);
                    }
                }else{
                    $('#validSnowflake').hide();
                    $('#invalidSnowflake').hide();
                }
            }
        </script>

    </div>
@endsection
