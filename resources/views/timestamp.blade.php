<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Timestamp Styles') }}</h2>
    <div class="py-12 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-3 gap-y-3 md:gap-y-0">
            <x-input-prepend-icon icon="fas fa-calendar-alt">
                <input
                    wire:ignore
                    wire:model="date"
                    type="date"
                    class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                />
            </x-input-prepend-icon>

            <x-input-prepend-icon icon="far fa-clock">
                <input
                    wire:ignore
                    wire:model="time"
                    type="time"
                    class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                />
            </x-input-prepend-icon>

            <x-input-prepend-icon icon="fas fa-globe-europe">
                <select
                    wire:ignore
                    wire:model="timezone"
                    id="selectTimezone"
                    class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                    @php
                        $tzList = DateTimeZone::listIdentifiers();
                        foreach ($tzList as $tz)
                            echo '<option value="' . $tz . '">' . $tz . '</option>';
                    @endphp
                </select>
            </x-input-prepend-icon>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-3 md:gap-y-0">
            <x-input-prepend-icon icon="far fa-snowflake">
                <input
                    wire:ignore
                    wire:model="snowflake"
                    type="number"
                    placeholder="{{ __('Snowflake') }}"
                    class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                />
            </x-input-prepend-icon>

            <x-input-prepend-icon icon="fas fa-code">
                <input
                    wire:ignore
                    wire:model="timestamp"
                    type="number"
                    placeholder="{{ __('Timestamp') }}"
                    class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                />
            </x-input-prepend-icon>
        </div>
        <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
            <div class="p-5 lg:p-6 grow w-full">
                <div class="flex flex-col text-center md:text-left text-sm">
                    <div class="hidden md:grid grid-cols-1 md:grid-cols-3 p-3 border-b-2 border-discord-gray-4 font-semibold tracking-wider uppercase">
                        <div>{{ __('Syntax') }}</div>
                        <div>{{ __('Preview') }}</div>
                        <div>{{ __('Description') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3 border-b border-discord-gray-4">
                        <div class="order-last md:order-first"><x-input-copy value="<t:{{ $timestamp }}:t>" hash="{{ Str::random() }}" /></div>
                        <div class="my-2 md:my-auto" id="momentShortTime"></div>
                        <div class="my-auto order-first md:order-last">{{ __('Short Time') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3 border-b border-discord-gray-4">
                        <div class="order-last md:order-first"><x-input-copy value="<t:{{ $timestamp }}:T>" hash="{{ Str::random() }}" /></div>
                        <div class="my-2 md:my-auto" id="momentLongTime"></div>
                        <div class="my-auto order-first md:order-last">{{ __('Long Time') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3 border-b border-discord-gray-4">
                        <div class="order-last md:order-first"><x-input-copy value="<t:{{ $timestamp }}:d>" hash="{{ Str::random() }}" /></div>
                        <div class="my-2 md:my-auto" id="momentShortDate"></div>
                        <div class="my-auto order-first md:order-last">{{ __('Short Date') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3 border-b border-discord-gray-4">
                        <div class="order-last md:order-first"><x-input-copy value="<t:{{ $timestamp }}:D>" hash="{{ Str::random() }}" /></div>
                        <div class="my-2 md:my-auto" id="momentLongDate"></div>
                        <div class="my-auto order-first md:order-last">{{ __('Long Date') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3 border-b border-discord-gray-4">
                        <div class="order-last md:order-first"><x-input-copy value="<t:{{ $timestamp }}:f>" hash="{{ Str::random() }}" /></div>
                        <div class="my-2 md:my-auto" id="momentShortDateTime"></div>
                        <div class="my-auto order-first md:order-last">{{ __('Short Date/Time') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3 border-b border-discord-gray-4">
                        <div class="order-last md:order-first"><x-input-copy value="<t:{{ $timestamp }}:F>" hash="{{ Str::random() }}" /></div>
                        <div class="my-2 md:my-auto" id="momentLongDateTime"></div>
                        <div class="my-auto order-first md:order-last">{{ __('Long Date/Time') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3 border-b border-discord-gray-4">
                        <div class="order-last md:order-first"><x-input-copy value="<t:{{ $timestamp }}:R>" hash="{{ Str::random() }}" /></div>
                        <div class="my-2 md:my-auto" id="momentRelativeTime"></div>
                        <div class="my-auto order-first md:order-last">{{ __('Relative Time') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 p-3">
                        <div class="order-last md:order-first"><x-input-copy value="{{ $timestamp }}" hash="{{ Str::random() }}" /></div>
                        <div class="my-auto">{{ $timestamp }}</div>
                        <div class="my-auto order-first md:order-last">{{ __('Timestamp') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var currentTimestamp = 0;
        document.addEventListener('DOMContentLoaded', () => {
            $(function () {
                Livewire.emit('changeTimezone', Intl.DateTimeFormat().resolvedOptions().timeZone);
                setInterval(updateTimestamp, 1000);
            })

            setTimestamp('{{ $timestamp }}');
        })

        window.addEventListener('updateTimestamp', event => setTimestamp(event.detail.timestamp));

        function setTimestamp(timestamp) {
            currentTimestamp = timestamp;
            updateTimestamp();
        }

        function updateTimestamp() {
            const mom = moment(currentTimestamp * 1000);
            document.getElementById('momentShortTime').innerText = mom.format('LT');
            document.getElementById('momentLongTime').innerText = mom.format('LTS');
            document.getElementById('momentShortDate').innerText = mom.format('L');
            document.getElementById('momentLongDate').innerText = mom.format('LL');
            document.getElementById('momentShortDateTime').innerText = mom.format('LLL');
            document.getElementById('momentLongDateTime').innerText = mom.format('LLLL');
            document.getElementById('momentRelativeTime').innerText = mom.fromNow();
        }
    </script>
</div>
