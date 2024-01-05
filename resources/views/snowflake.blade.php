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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-3 gap-y-3 md:gap-y-0">
                <a role="button" href="{{ route('userlookup', ['snowflake' => $snowflake]) }}" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">{{ __('Lookup User') }}</a>
                <a role="button" href="{{ route('guildlookup', ['snowflake' => $snowflake]) }}" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">{{ __('Lookup Guild') }}</a>
                <a role="button" href="{{ route('applicationlookup', ['snowflake' => $snowflake]) }}" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">{{ __('Lookup Application') }}</a>
            </div>
        @endif
    </div>
</div>
