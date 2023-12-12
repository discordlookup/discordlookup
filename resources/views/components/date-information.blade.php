<div>
    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
        @if(isset($title))
            <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                <h3 class="font-semibold">{{ $title }}</h3>
            </div>
        @endif
        <div class="p-5 lg:p-6 grow w-full">
            <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <b>Date<span class="hidden md:inline">:</span></b>
                    <p id="date"></p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <b>Relative<span class="hidden md:inline">:</span></b>
                    <p id="relative"></p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <b>Unix Timestamp<span class="hidden md:inline">:</span></b>
                    <p id="timestamp">
                        <a href="{{ route('timestamp', ['timestampSlug' => round(intval($snowflake) / 1000)]) }}" class="text-discord-blurple">

                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const date = convertSnowflakeToDate('{{ $snowflake }}');
        document.getElementById('date').innerHTML = moment.utc(date).local().format('dddd, MMMM Do YYYY, h:mm:ss a');
        document.getElementById('relative').innerHTML = moment.utc(date).local().fromNow();
        document.getElementById('timestamp').innerHTML = convertSnowflakeToDate('{{ $snowflake }}').getTime();
    </script>
</div>
