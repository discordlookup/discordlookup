<div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
    @isset($title)
        <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
            <h3 class="font-semibold">{{ $title }}</h3>
        </div>
    @endisset
    <div class="p-5 lg:p-6 grow w-full">
        <div class="flex flex-col gap-y-5 md:gap-y-0.5">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <span class="font-semibold">{{ __('Date') }}<span class="hidden md:inline">:</span></span>
                <p>{{ date('Y-m-d G:i:s \(T\)', getTimestamp($snowflake) / 1000) }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <span class="font-semibold">{{ __('Relative') }}<span class="hidden md:inline">:</span></span>
                <p>{{ \Carbon\Carbon::createFromTimestamp(getTimestamp($snowflake) / 1000)->diffForHumans() }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <span class="font-semibold">{{ __('Unix Timestamp') }}<span class="hidden md:inline">:</span></span>
                <p>
                    <a href="{{ route('timestamp', ['timestampSlug' => round(getTimestamp($snowflake) / 1000)]) }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]" id="timestamp">
                        {{ round(getTimestamp($snowflake) / 1000) }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
