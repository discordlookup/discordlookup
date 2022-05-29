@section('title', __('Timestamp Styles'))
@section('description', __('Generate Discord timestamp styles based on a date, time, snowflake or timestamp.'))
@section('keywords', 'timestamp, time, date, styles, format, formatting, snowflake')
@section('robots', 'index, follow')

<div id="timestamp">
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Timestamp Styles') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-xl-3 offset-xl-1">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <input wire:ignore wire:model="date" class="form-control form-control-lg" type="date">
                </div>
            </div>
            <div class="col-12 col-xl-3 mt-3 mt-xl-0">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-clock"></i>
                    </span>
                    <input wire:ignore wire:model="time" class="form-control form-control-lg" type="time">
                </div>
            </div>
            <div class="col-12 col-xl-4 mt-3 mt-xl-0">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="fas fa-globe-europe"></i>
                    </span>
                    <select wire:ignore wire:model="timezone" class="form-select" id="selectTimezone">
                        @php
                            $tzList = DateTimeZone::listIdentifiers();
                            foreach ($tzList as $tz)
                                echo "<option>{$tz}</option>";
                        @endphp
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-xl-5 offset-xl-1">
                <div class="input-group input-group-lg">
                <span class="input-group-text bg-dark">
                    <i class="far fa-snowflake"></i>
                </span>
                    <input wire:ignore wire:model="snowflake" class="form-control form-control-lg" type="text" placeholder="{{ __('Snowflake') }}">
                </div>
            </div>
            <div class="col-12 col-xl-5 mt-3 mt-xl-0">
                <div class="input-group input-group-lg">
                <span class="input-group-text bg-dark">
                    <i class="fas fa-code"></i>
                </span>
                    <input wire:ignore wire:model="timestamp" class="form-control form-control-lg" type="text" placeholder="{{ __('Timestamp') }}">
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-10 offset-xl-1 mt-3">
            <div class="card text-white bg-dark">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Syntax') }}</th>
                            <th class="w-50" scope="col">{{ __('Example') }}</th>
                            <th scope="col">{{ __('Description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputShortTime" aria-label="Copy to clipboard" aria-describedby="buttonShortTime" value="<t:{{ $timestamp }}:t>" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonShortTime" onclick="copyToClipboard('ShortTime')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successShortTime">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td id="momentShortTime"></td>
                            <td>{{ __('Short Time') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputLongTime" aria-label="Copy to clipboard" aria-describedby="buttonLongTime" value="<t:{{ $timestamp }}:T>" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonLongTime" onclick="copyToClipboard('LongTime')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successLongTime">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td id="momentLongTime"></td>
                            <td>{{ __('Long Time') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputShortDate" aria-label="Copy to clipboard" aria-describedby="buttonShortDate" value="<t:{{ $timestamp }}:d>" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonShortDate" onclick="copyToClipboard('ShortDate')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successShortDate">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td id="momentShortDate"></td>
                            <td>{{ __('Short Date') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputLongDate" aria-label="Copy to clipboard" aria-describedby="buttonLongDate" value="<t:{{ $timestamp }}:D>" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonLongDate" onclick="copyToClipboard('LongDate')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successLongDate">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td id="momentLongDate"></td>
                            <td>{{ __('Long Date') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputShortDateTime" aria-label="Copy to clipboard" aria-describedby="buttonShortDateTime" value="<t:{{ $timestamp }}:f>" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonShortDateTime" onclick="copyToClipboard('ShortDateTime')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successShortDateTime">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td id="momentShortDateTime"></td>
                            <td>{{ __('Short Date/Time') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputLongDateTime" aria-label="Copy to clipboard" aria-describedby="buttonLongDateTime" value="<t:{{ $timestamp }}:F>" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonLongDateTime" onclick="copyToClipboard('LongDateTime')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successLongDateTime">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td id="momentLongDateTime"></td>
                            <td>{{ __('Long Date/Time') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputRelativeTime" aria-label="Copy to clipboard" aria-describedby="buttonRelativeTime" value="<t:{{ $timestamp }}:R>" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonRelativeTime" onclick="copyToClipboard('RelativeTime')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successRelativeTime">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td id="momentRelativeTime"></td>
                            <td>{{ __('Relative Time') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-gray-800 border-0 shadow-none" id="inputTimestamp" aria-label="Copy to clipboard" aria-describedby="buttonTimestamp" value="{{ $timestamp }}" readonly>
                                    <button class="btn btn-primary" type="button" id="buttonTimestamp" onclick="copyToClipboard('Timestamp')"><i class="far fa-clipboard"></i></button>
                                </div>
                                <div class="valid-feedback" id="successTimestamp">{{ __('Successfully copied to the clipboard.') }}</div>
                            </td>
                            <td>{{ $timestamp }}</td>
                            <td>{{ __('Timestamp') }}</td>
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

        function copyToClipboard(elemId) {
            const inputElem = document.getElementById('input' + elemId);
            inputElem.select();
            inputElem.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(inputElem.value);

            const successElem = document.getElementById('success' + elemId);
            successElem.style.display = 'block';
            setTimeout(() => successElem.style.display = 'none', 3000);
        }
    </script>
</div>
