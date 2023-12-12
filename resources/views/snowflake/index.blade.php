@section('title', __('Snowflake Decoder'))
@section('description', __('Get the creation date of a Snowflake, and detailed information about Discord users, guilds and applications.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Snowflake') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <x-input-prepend-icon icon="far fa-snowflake">
            <input
                wire:model="snowflake"
                placeholder="{{ __('Snowflake') }}"
                type="number"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </x-input-prepend-icon>

        @if($errorMessage)
            <x-error-message>
                {{ $errorMessage }}
            </x-error-message>
        @elseif($snowflakeDate && $snowflakeTimestamp)
            <x-date-information snowflake="{{ $snowflake }}" />

            <a role="button" href="{{ route('userlookup') }}/{{ $snowflake }}" class="btn btn-primary w-100 mt-5">{{ __('Lookup User') }}</a>
            <a role="button" href="{{ route('guildlookup') }}/{{ $snowflake }}" class="btn btn-primary w-100 mt-3">{{ __('Lookup Guild') }}</a>
            {{--<a role="button" href="{{ route('applicationlookup') }}/{{ $snowflake }}" class="btn btn-primary w-100 mt-3">{{ __('Lookup Application') }}</a>--}}
        @endif
    </div>
</div>
