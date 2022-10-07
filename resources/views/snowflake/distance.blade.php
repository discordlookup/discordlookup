@section('title', __('Snowflake Distance Calculator'))
@section('description', __('Calculate the distance between two Discord Snowflakes.'))
@section('keywords', 'snowflakes, two snowflakes, distance, calculate', 'time', 'date')
@section('robots', 'index, follow')

<div>
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Snowflake Distance Calculator') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-xl-6 offset-xl-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake1Display" class="form-control form-control-lg" type="text" placeholder="{{ __('Snowflake 1') }}">
                </div>
            </div>
            <div class="col-12 col-xl-6 offset-xl-3 mt-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="snowflake2" class="form-control form-control-lg" type="text" placeholder="{{ __('Snowflake 2') }}">
                </div>
            </div>
            @if($errorMessage)
                <div class="col-12 col-xl-6 offset-xl-3 mt-3">
                    <div class="alert alert-danger fade show" role="alert">
                        {{ $errorMessage }}
                    </div>
                </div>
            @elseif($snowflake1Date && $snowflake1Timestamp && $snowflake2Date && $snowflake2Timestamp)
                <div class="col-12 col-xl-6 offset-xl-3 mt-3">
                    <div class="card text-white bg-dark">
                        <div class="card-body text-center">
                            <h2 class="fw-bold">{{ __('Distance between the two Snowflakes:') }}</h2>
                            <h3 class="fw-bold text-primary" id="snowflakeDistance"></h3>
                        </div>
                    </div>
                    <hr>
                    <div class="card text-white bg-dark">
                        <div class="card-body text-center">
                            <h5>{{ __('Snowflake 1') }}</h5>
                            <b>{{ __('Date') }}:</b> {{ $snowflake1Date }}<br>
                            <b>{{ __('Relative') }}:</b> <span id="snowflakeOneRelative"></span><br>
                            <b>{{ __('Unix Timestamp') }}:</b> <a href="{{ route('timestamp', ['timestamp' => round($snowflake1Timestamp / 1000)]) }}" class="text-decoration-none">{{ $snowflake1Timestamp }}</a><br>
                        </div>
                    </div>
                    <div class="card text-white bg-dark mt-3">
                        <div class="card-body text-center">
                            <h5>{{ __('Snowflake 2') }}</h5>
                            <b>{{ __('Date') }}:</b> {{ $snowflake2Date }}<br>
                            <b>{{ __('Relative') }}:</b> <span id="snowflakeTwoRelative"></span><br>
                            <b>{{ __('Unix Timestamp') }}:</b> <a href="{{ route('timestamp', ['timestamp' => round($snowflake2Timestamp / 1000)]) }}" class="text-decoration-none">{{ $snowflake2Timestamp }}</a><br>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        @if($snowflake1Timestamp && $snowflake2Timestamp)
            document.addEventListener('DOMContentLoaded', () => update({{ $snowflake1Timestamp }}, {{ $snowflake2Timestamp }}));
        @endif
        window.addEventListener('update', event => update(event.detail.timestamp1, event.detail.timestamp2));

        function update(timestamp1, timestamp2)
        {
            const moment1 = moment(timestamp1);
            const moment2 = moment(timestamp2);
            let difference = moment.duration(moment1.diff(moment2));
            if(timestamp2 > timestamp1) {
                difference = moment.duration(moment2.diff(moment1));
            }
            document.getElementById('snowflakeDistance').innerHTML =
                difference.years() + " <small>" + (difference.years() === 1 ? "{{ trans_choice('year|years', 1) }}" : "{{ trans_choice('year|years', 0) }}") + "</small><br>" +
                difference.months() + " <small>" + (difference.months() === 1 ? "{{ trans_choice('month|months', 1) }}" : "{{ trans_choice('month|months', 0) }}") + "</small><br>" +
                difference.days() + " <small>" + (difference.days() === 1 ? "{{ trans_choice('day|days', 1) }}" : "{{ trans_choice('day|days', 0) }}") + "</small><br>" +
                difference.hours() + " <small>" + (difference.hours() === 1 ? "{{ trans_choice('hour|hours', 1) }}" : "{{ trans_choice('hour|hours', 0) }}") + "</small><br>" +
                difference.minutes() + " <small>" + (difference.minutes() === 1 ? "{{ trans_choice('minute|minutes', 1) }}" : "{{ trans_choice('minute|minutes', 0) }}") + "</small><br>" +
                difference.seconds() + " <small>" + (difference.seconds() === 1 ? "{{ trans_choice('second|seconds', 1) }}" : "{{ trans_choice('second|seconds', 0) }}") + "</small><br>" +
                difference.milliseconds() + " <small>" + (difference.milliseconds() === 1 ? "{{ trans_choice('millisecond|milliseconds', 1) }}" : "{{ trans_choice('millisecond|milliseconds', 0) }}") + "</small><br>"
            ;
            document.getElementById('snowflakeOneRelative').innerText = moment.utc(timestamp1).local().fromNow();
            document.getElementById('snowflakeTwoRelative').innerText = moment.utc(timestamp2).local().fromNow();
        }
    </script>
</div>
