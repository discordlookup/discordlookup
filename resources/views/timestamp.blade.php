@section('title', __('Timestamp Styles'))
@section('description', __('Generate Discord timestamp styles based on a date, time, snowflake or timestamp.'))
@section('keywords', 'timestamp, time, date, styles, format, formatting, snowflake')
@section('robots', 'index, follow')

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
                <table class="min-w-full text-sm align-middle whitespace-nowrap">
                    <thead>
                    <tr class="border-b-2 border-discord-gray-4">
                        <th class="p-3 font-semibold text-sm tracking-wider uppercase text-left">{{ __('Syntax') }}</th>
                        <th class="p-3 font-semibold text-sm tracking-wider uppercase text-left">{{ __('Preview') }}</th>
                        <th class="p-3 font-semibold text-sm tracking-wider uppercase text-left">{{ __('Description') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr class="border-b border-discord-gray-4">
                        <td class="p-3"><x-input-copy value="<t:{{ $timestamp }}:t>" hash="{{ Str::random() }}" /></td>
                        <td class="p-3" id="momentShortTime"></td>
                        <td class="p-3">{{ __('Short Time') }}</td>
                    </tr>
                    <tr class="border-b border-discord-gray-4">
                        <td class="p-3"><x-input-copy value="<t:{{ $timestamp }}:T>" hash="{{ Str::random() }}" /></td>
                        <td class="p-3" id="momentLongTime"></td>
                        <td class="p-3">{{ __('Long Time') }}</td>
                    </tr>
                    <tr class="border-b border-discord-gray-4">
                        <td class="p-3"><x-input-copy value="<t:{{ $timestamp }}:d>" hash="{{ Str::random() }}" /></td>
                        <td class="p-3" id="momentShortDate"></td>
                        <td class="p-3">{{ __('Short Date') }}</td>
                    </tr>
                    <tr class="border-b border-discord-gray-4">
                        <td class="p-3"><x-input-copy value="<t:{{ $timestamp }}:D>" hash="{{ Str::random() }}" /></td>
                        <td class="p-3" id="momentLongDate"></td>
                        <td class="p-3">{{ __('Long Date') }}</td>
                    </tr>
                    <tr class="border-b border-discord-gray-4">
                        <td class="p-3"><x-input-copy value="<t:{{ $timestamp }}:f>" hash="{{ Str::random() }}" /></td>
                        <td class="p-3" id="momentShortDateTime"></td>
                        <td class="p-3">{{ __('Short Date/Time') }}</td>
                    </tr>
                    <tr class="border-b border-discord-gray-4">
                        <td class="p-3"><x-input-copy value="<t:{{ $timestamp }}:F>" hash="{{ Str::random() }}" /></td>
                        <td class="p-3" id="momentLongDateTime"></td>
                        <td class="p-3">{{ __('Long Date/Time') }}</td>
                    </tr>
                    <tr class="border-b border-discord-gray-4">
                        <td class="p-3"><x-input-copy value="<t:{{ $timestamp }}:R>" hash="{{ Str::random() }}" /></td>
                        <td class="p-3" id="momentRelativeTime"></td>
                        <td class="p-3">{{ __('Relative Time') }}</td>
                    </tr>
                    <tr>
                        <td class="p-3"><x-input-copy value="{{ $timestamp }}" hash="{{ Str::random() }}" /></td>
                        <td class="p-3">{{ $timestamp }}</td>
                        <td class="p-3">{{ __('Timestamp') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $(function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
                Livewire.emit('changeTimezone', Intl.DateTimeFormat().resolvedOptions().timeZone);
            })

            Livewire.hook('message.processed', (message, component) => {
                $(function () {
                    $('[data-bs-toggle="tooltip"]').tooltip()
                })
            })

            timestamp('{{ $timestamp }}');
        })

        window.addEventListener('updateTimestamp', event => timestamp(event.detail.timestamp));

        {{-- TODO: Live Update --}}
        function timestamp(timestamp) {
            const mom = moment(timestamp * 1000);
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
