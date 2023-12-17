@if($experiment)
    @section('title', "{$experiment['title']} Experiment")
    @section('description', "Information and rollout status about the {$experiment['title']} Experiment.")
    @section('keywords', "client, guild, experiments, discord experiments, rollout, rollouts, treatments, groups, overrides, population, {$experiment['id']}")
    @section('robots', 'index, follow')

    <div>
        <h2 class="text-2xl md:text-4xl text-center font-extrabold mb-2 text-white">{{ $experiment['title'] }}</h2>
        <h3 class="text-sm md:text-xl text-center mb-4 text-gray-300">{{ $experiment['id'] }} ({{ $experiment['hash'] }})</h3>
        <div class="py-12">
            <div class="space-y-3 mb-12">
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                        <h3 class="font-semibold">
                            {{ __('Treatments') }}
                            <i class="far fa-question-circle text-gray-300 text-sm" title="{{ __('Different versions of the experiment that can be activated') }}"></i>
                        </h3>
                    </div>
                    <div class="p-5 lg:p-6 grow w-full">
                        <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                            @foreach($buckets as $bucket)
                                {{-- TODO --}}
                                <h5 class="mb-3 text-primary">
                                    {{ $bucket['name'] }}
                                    <small class="text-white-50">{!! ($bucket['description'] ? : '<i>' . __('No description') . '</i>') !!}</small>
                                </h5>
                                @if($overrides && array_key_exists($bucket['id'], $overrides))
                                    <div>
                                        <b>{{ __('Overrides') }} ({{ sizeof($overrides[$bucket['id']]) }})</b> <i class="far fa-question-circle text-muted small align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Server that have the treatment in any case') }}"></i><br>
                                        @foreach($overrides[$bucket['id']] as $override)
                                            @if($loop->index == 12)
                                                <span class="badge bg-primary" style="cursor: pointer;" onclick="document.getElementById('allOverrides{{ $bucket['id'] }}').style.display = '';this.style.display = 'none';">
                                                    {{ __('Show all') }}
                                                </span>
                                                <span id="allOverrides{{ $bucket['id'] }}" style="display: none">
                                            @endif
                                            <a href="{{ route('guildlookup', ['snowflake' => $override]) }}"
                                               class="text-decoration-none" rel="nofollow">
                                                <span class="badge bg-body">{{ $override }}</span>
                                            </a>
                                            @if($loop->last)</span>@endif
                                        @endforeach
                                        <br>
                                    </div>
                                @endif
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        </div>
                    </div>
                </div>

                @foreach($rollouts as $rollout)
                    {{-- TODO --}}
                    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                        <div class="p-5 lg:p-6 grow w-full">
                            <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                                @if($rollout['filters'])
                                    <span class="text-primary fw-bold">{{ __('Filter') }}:</span><br>
                                    <ul class="lh-1">
                                        @foreach($rollout['filters'] as $filter)
                                            <li class="mt-2">
                                                <span class="text-white">{{ $filter }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                @endif
                                @foreach($rollout['buckets'] as $bucket)
                                    @php($bucketInfo = $buckets["BUCKET {$bucket['id']}"] ?? ['id' => -1, 'name' => 'None', 'description' => ''])
                                    <div>
                                        @if($bucketInfo['name'] == 'None' || $bucketInfo['name'] == 'Control')
                                            <span class="text-danger fw-semibold">{{ $bucketInfo['name'] }}</span>
                                        @else
                                            <span class="text-success fw-semibold">{{ $bucketInfo['name'] }}</span>
                                        @endif

                                        <span class="text-white-50">
                                            {{ $bucketInfo['description'] }}@if($bucketInfo['description']):
                                            @endif
                                            <b>{{ $bucket['count'] / (10000)*100 }}&percnt;</b>
                                            @if($bucket['groups'])
                                                <span class="small">
                                                    @foreach($bucket['groups'] as $group)
                                                        @if($loop->first)(@endif{{ $group['start'] }} - {{ $group['end'] }}@if($loop->last))@else, @endif
                                                    @endforeach()
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="space-y-3">
                @if($experiment['type'] == 'guild' && $experiment['rollout'])
                    @guest
                        <x-login-required />
                    @endguest

                    @auth
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-x-3 gap-y-3 md:gap-y-0">
                            <x-input-prepend-icon icon="fas fa-bucket">
                                <select wire:model="treatment" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                                    @foreach($buckets as $bucket)
                                        <option value="{{ $bucket['id'] }}">{{ $bucket['name'] }}</option>
                                    @endforeach
                                </select>
                            </x-input-prepend-icon>

                            <x-input-prepend-icon icon="fas fa-search" class="col-span-2">
                                <input
                                    wire:model="search"
                                    type="text"
                                    placeholder="{{ __('Search...') }}"
                                    class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                                >
                            </x-input-prepend-icon>

                            <x-input-prepend-icon icon="fas fa-sort-alpha-down">
                                <select wire:model="sorting" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                                    <option value="name-asc" selected>{{ __('Name Ascending') }}</option>
                                    <option value="name-desc">{{ __('Name Descending') }}</option>
                                    <option value="id-asc">{{ __('Created Ascending') }}</option>
                                    <option value="id-desc">{{ __('Created Descending') }}</option>
                                </select>
                            </x-input-prepend-icon>
                        </div>

                        @if(empty($guilds))
                            <x-error-message>
                                {{ __('No Guild found.') }}
                            </x-error-message>
                        @else
                            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                                <div class="grow px-5 py-3">
                                    <div class="min-w-full overflow-x-auto">
                                        <table class="min-w-full whitespace-nowrap align-middle text-sm">
                                            <tbody>
                                            @foreach($guilds as $guildTreatments)
                                                @php($guild = $guildTreatments['guild'])
                                                <tr class="{{ $loop->last ?: 'border-b border-discord-gray-4' }}">
                                                    <td class="p-3 text-center">
                                                        @if($guild['icon'])
                                                            <a href="{{ env('DISCORD_CDN_URL') }}/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}" target="_blank">
                                                                <img src="{{ env('DISCORD_CDN_URL') }}/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}?size=128" loading="lazy" class="inline-block h-12 w-12 rounded-full" alt="guild icon">
                                                            </a>
                                                        @else
                                                            <img src="{{ env('DISCORD_CDN_URL') }}/embed/avatars/0.png" loading="lazy" class="inline-block h-12 w-12 rounded-full" alt="guild default icon">
                                                        @endif
                                                    </td>
                                                    <td class="p-3">
                                                        <p class="font-bold">
                                                            {{ cutString($guild['name'], 80) }}
                                                            @if($guild['owner']) {!! getDiscordBadgeServerIcons('owner', __('You own')) !!}
                                                            @elseif(hasAdministrator($guild['permissions'])) {!! getDiscordBadgeServerIcons('administrator', __('You administrate')) !!}
                                                            @elseif(hasModerator($guild['permissions'])) {!! getDiscordBadgeServerIcons('moderator', __('You moderate')) !!} @endif
                                                            @if(in_array('VERIFIED', $guild['features'])) {!! getDiscordBadgeServerIcons('verified', __('Discord Verified')) !!} @endif
                                                            @if(in_array('PARTNERED', $guild['features'])) {!! getDiscordBadgeServerIcons('partner', __('Discord Partner')) !!} @endif
                                                        </p>
                                                        <p class="text-gray-400">
                                                            {{ $guild['id'] }} &bull; {{ date('Y-m-d', getTimestamp($guild['id']) / 1000) }}
                                                        </p>

                                                        @if($guildTreatments['override'])
                                                            <p class="text-sm text-discord-green">
                                                                ({{ __('This Guild has an override for this experiment') }})
                                                            </p>
                                                        @else
                                                            <p class="text-sm text-gray-300">
                                                                @foreach($guildTreatments['filters'] as $filter)
                                                                    {{ $filter }}
                                                                @endforeach
                                                            </p>
                                                        @endif

                                                    </td>
                                                    <td class="py-3 pl-3 text-right">
                                                        <a role="button"
                                                           href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}"
                                                           target="_blank"
                                                           class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                        >
                                                            {{ __('Guild Lookup') }}
                                                        </a>

                                                        <button
                                                            x-on:click="modalFeaturesOpen = true"
                                                            wire:click="$emitTo('modal.guild-features', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')"
                                                            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                        >
                                                            {{ __('Features') }}
                                                        </button>

                                                        <button
                                                            x-on:click="modalPermissionsOpen = true"
                                                            wire:click="$emitTo('modal.guild-permissions', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')"
                                                            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                        >
                                                            {{ __('Permissions') }}
                                                        </button>

                                                        <button
                                                            x-on:click="modalExperimentsOpen = true"
                                                            wire:click="$emitTo('modal.guild-experiments', 'update', '{{ $guild['id'] }}', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')"
                                                            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                                        >
                                                            {{ __('Experiments') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

    @livewire('modal.guild-features')
    @livewire('modal.guild-permissions')
    @livewire('modal.guild-experiments')
@else
    <div>
        <h1 class="mb-1 mt-5 text-center text-white">
            {{ __('The page could not be loaded! Please try again.') }}
        </h1>
    </div>
@endif
