<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Snowflake Distance') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <x-input-prepend-icon icon="far fa-snowflake">
            <input
                wire:model="snowflake1Display"
                placeholder="{{ __('Snowflake 1') }}"
                type="number"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </x-input-prepend-icon>

        <x-input-prepend-icon icon="far fa-snowflake">
            <input
                wire:model="snowflake2"
                placeholder="{{ __('Snowflake 2') }}"
                type="number"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </x-input-prepend-icon>

        @if($errorMessage)
            <x-error-message>
                {{ $errorMessage }}
            </x-error-message>
        @elseif($snowflake1 && $snowflake2 && $snowflake1 != '-')
            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                <div class="p-5 lg:p-6 grow w-full text-center text-2xl font-bold">
                    {{-- __('The Snowflakes occured at the same time.') --}}
                    {{ __('Distance between the two Snowflakes:') }}
                    <div class="text-discord-blurple font-bold">
                        <span id="snowflakeDistance"></span>
                    </div>
                </div>
            </div>
            <x-date-information snowflake="{{ $snowflake1 }}" title="Snowflake 1" />
            <x-date-information snowflake="{{ $snowflake2 }}" title="Snowflake 2" />
        @endif

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
        }
    </script>
</div>
