<div x-data="{ modalExperimentsOpen: false, modalFeaturesOpen: false, modalPermissionsOpen: false }">
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-2 text-white">{{ $experiment['title'] }}</h2>
    <h3 class="text-lg md:text-xl text-center mb-4 text-gray-300">
        {{ $experiment['id'] }} ({{ $experiment['hash'] }})
        @if($this->experiment['rollout'][8])
            <div class="text-sm">{{ __('A/A Mode') }}</div>
        @endif
        @if($experiment['type'] == 'guild' && $experiment['rollout'])
            <div class="text-sm">
                {{ __('Revision') }} {{ $experiment['rollout'][2] }}
            </div>
        @endif
        @if($experiment['type'] == 'guild' && $this->experiment['rollout'][6])
            <div class="text-sm">
                {{ __('Holdout') }}: {{ $this->experiment['rollout'][6] }}, {{ $this->experiment['rollout'][7] }}
            </div>
        @endif
    </h3>
    <div class="py-12">
        <div class="space-y-3 mb-12">
            @if($this->experiment['rollout'][8])
                <x-error-message>
                    This experiment has A/A mode enabled! Non-overrides are ignored.
                </x-error-message>
            @endif

            @if ($experiment['id'] === "2025-02_skill_trees")
                <div class="bg-discord-gray-1 rounded shadow-sm px-4 py-3 flex items-center justify-between w-full">
                    <img src="https://cdn.discordapp.com/icons/1369345883639906425/14a46c92b58abb409c8d9b25757e4447.webp?size=32" alt="Server Icon" class="w-8 h-8 mr-4">
                    <div class="text-white text-sm font-semibold flex-1">
                        Do you want to see the experiment live on Discord and also wear a server tag on your profile?<br>
                        <span class="text-gray-300 font-normal">Feel free to join our server with this experiment and claim your tag!</span>
                    </div>
                    <a href="https://discord.gg/easypoll" target="_blank"
                        class="bg-discord-blurple hover:bg-[#4752c4] text-white text-sm font-semibold py-1.5 px-3 rounded ml-4 transition">
                        Join Server
                    </a>
                </div>
            @endif

            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                    <h3 class="text-2xl font-semibold">
                        {{ __('Treatments') }}
                        <i class="far fa-question-circle text-gray-300 text-sm" title="{{ __('Different versions of the experiment that can be activated') }}"></i>
                    </h3>
                </div>
                <div class="p-5 lg:p-6 grow w-full">
                    <div class="flex flex-col">
                        @foreach($buckets as $bucket)
                            <div class="space-y-3">
                                <h4 class="text-xl text-discord-blurple font-bold">
                                    {{ $bucket['name'] }}
                                    <span class="text-sm font-semibold text-gray-300">
                                            {!! ($bucket['description'] ?: '<i>' . __('No description') . '</i>') !!}
                                        </span>
                                </h4>
                                @if($overrides && array_key_exists($bucket['id'], $overrides))
                                    <div>
                                        <div>
                                            <span class="font-semibold">{{ __('Overrides') }} ({{ sizeof($overrides[$bucket['id']]) }})</span>
                                            <i class="far fa-question-circle text-gray-300 text-sm" title="{{ __('Server that have the treatment in any case') }}"></i>
                                        </div>

                                        @foreach($overrides[$bucket['id']] as $override)
                                            @if($loop->index == 14)
                                                <div
                                                    class="inline-flex rounded bg-discord-blurple px-2 py-1 text-xs font-semibold leading-3 text-gray-200 cursor-pointer"
                                                    onclick="document.getElementById('allOverrides{{ $bucket['id'] }}').style.display = '';this.style.display = 'none';"
                                                >
                                                    {{ __('Show all') }}
                                                </div>
                                                <span id="allOverrides{{ $bucket['id'] }}" style="display: none">
                                                @endif

                                                <a href="{{ route('guildlookup', ['snowflake' => $override]) }}" target="_blank" rel="nofollow">
                                                    <div class="inline-flex rounded bg-discord-gray-4 px-2 py-1 text-xs font-semibold leading-3 text-gray-200">{{ $override }}</div>
                                                </a>

                                                @if($loop->last)
                                                    </span>
                                            @endif
                                        @endforeach
                                        <br>
                                    </div>
                                @endif
                            </div>
                            @if(!$loop->last)
                                <hr class="my-3 opacity-10" />
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            @foreach($rollouts as $rollout)
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="p-5 lg:p-6 grow w-full">
                        <div class="flex flex-col">
                            @if($rollout['filters'])
                                <p class="text-lg text-discord-blurple font-bold">{{ __('Filter') }}:</p>
                                <ul class="list-inside list-disc">
                                    @foreach($rollout['filters'] as $filter)
                                        <li>{{ $filter }}</li>
                                    @endforeach
                                </ul>
                                <hr class="my-3 opacity-10" />
                            @endif
                            @foreach($rollout['buckets'] as $bucket)
                                @php
                                    if($bucket['id'] != -1) {
                                        if (array_key_exists("BUCKET {$bucket['id']}", $buckets)) {
                                            $bucketInfo = $buckets["BUCKET {$bucket['id']}"];
                                        }else{
                                            $bucketInfo = [
                                                'id' => $bucket['id'],
                                                'name' => "Unknown Treatment {$bucket['id']}",
                                                'description' => "",
                                            ];
                                        }
                                    }else{
                                        $bucketInfo = $buckets["BUCKET {$bucket['id']}"] ?? ['id' => -1, 'name' => 'None', 'description' => ''];
                                    }
                                @endphp
                                <div>
                                    @if($bucketInfo['name'] == 'None' || $bucketInfo['name'] == 'Control')
                                        <span class="text-discord-red font-bold">{{ $bucketInfo['name'] }}</span>
                                    @else
                                        <span class="text-discord-green font-bold">{{ $bucketInfo['name'] }}</span>
                                    @endif

                                    <span class="text-gray-300">
                                            @if($bucketInfo['description'])
                                            {{ $bucketInfo['description'] }}:
                                        @endif

                                            <span class="font-semibold">{{ calcPercent($bucket['count'], 10000) }}&percnt;</span>

                                            @if($bucket['groups'])
                                            <span class="text-sm">
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

            @if($overridesFormatted)
                <h3 class="text-2xl font-semibold">
                    Overrides Formatted:
                </h3>
            @endif

            @foreach($overridesFormatted as $rollout)
                {{-- TODO: Remove duplicate code --}}
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="p-5 lg:p-6 grow w-full">
                        <div class="flex flex-col">
                            @if($rollout['filters'])
                                <p class="text-lg text-discord-blurple font-bold">{{ __('Filter') }}:</p>
                                <ul class="list-inside list-disc">
                                    @foreach($rollout['filters'] as $filter)
                                        <li>{{ $filter }}</li>
                                    @endforeach
                                </ul>
                                <hr class="my-3 opacity-10" />
                            @endif
                            @foreach($rollout['buckets'] as $bucket)
                                @php
                                    if($bucket['id'] != -1) {
                                        if (array_key_exists("BUCKET {$bucket['id']}", $buckets)) {
                                            $bucketInfo = $buckets["BUCKET {$bucket['id']}"];
                                        }else{
                                            $bucketInfo = [
                                                'id' => $bucket['id'],
                                                'name' => "Unknown Treatment {$bucket['id']}",
                                                'description' => "",
                                            ];
                                        }
                                    }else{
                                        $bucketInfo = $buckets["BUCKET {$bucket['id']}"] ?? ['id' => -1, 'name' => 'None', 'description' => ''];
                                    }
                                @endphp
                                <div>
                                    @if($bucketInfo['name'] == 'None' || $bucketInfo['name'] == 'Control')
                                        <span class="text-discord-red font-bold">{{ $bucketInfo['name'] }}</span>
                                    @else
                                        <span class="text-discord-green font-bold">{{ $bucketInfo['name'] }}</span>
                                    @endif

                                    <span class="text-gray-300">
                                            @if($bucketInfo['description'])
                                            {{ $bucketInfo['description'] }}:
                                        @endif

                                            <span class="font-semibold">{{ calcPercent($bucket['count'], 10000) }}&percnt;</span>

                                            @if($bucket['groups'])
                                            <span class="text-sm">
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

        <div class="space-y-3" id="guilds">
            @if($experiment['type'] == 'guild' && $experiment['rollout'])
                @guest
                    <x-login-required />
                @endguest

                @auth
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-x-0 md:gap-x-3 gap-y-3 md:gap-y-0">
                        <x-input-prepend-icon icon="fas fa-bucket">
                            <select wire:model="treatment" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                                @foreach($buckets as $bucket)
                                    <option value="{{ $bucket['id'] }}" {{ $bucket['id'] == 0 ? 'disabled' : '' }}>{{ $bucket['name'] }}</option>
                                @endforeach
                            </select>
                        </x-input-prepend-icon>

                        {{-- TODO: Fix search input --}}
                        <div class="col-span-2"></div>
                        {{--
                        <x-input-prepend-icon icon="fas fa-search" class="col-span-2">
                            <input
                                wire:model="search"
                                type="text"
                                placeholder="{{ __('Search...') }}"
                                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                            >
                        </x-input-prepend-icon>
                        --}}

                        <x-input-prepend-icon icon="fas fa-sort-alpha-down">
                            <select wire:model="sorting" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                                <option value="name-asc" selected>{{ __('Name Ascending') }}</option>
                                <option value="name-desc">{{ __('Name Descending') }}</option>
                                <option value="id-asc">{{ __('Created Ascending') }}</option>
                                <option value="id-desc">{{ __('Created Descending') }}</option>
                                <option value="approximate_presence_count-asc">{{ __('Online Ascending') }}</option>
                                <option value="approximate_presence_count-desc">{{ __('Online Descending') }}</option>
                                <option value="approximate_member_count-asc">{{ __('Members Ascending') }}</option>
                                <option value="approximate_member_count-desc">{{ __('Members Descending') }}</option>
                            </select>
                        </x-input-prepend-icon>
                    </div>

                    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                        @if(empty($guilds))
                            <div class="py-4 px-5 text-gray-200 lg:px-6 w-full items-center">
                                {{ __('No guilds found.') }}
                            </div>
                        @else
                            <div class="px-5 py-3 grow w-full">
                                <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                                    @foreach($guilds as $guildTreatments)
                                        <x-guild-table-row :guild="$guildTreatments['guild']" :override="$guildTreatments['override']" :filters="$guildTreatments['filters']" />
                                        @if(!$loop->last)
                                            <hr class="opacity-10" />
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endauth
            @endif
        </div>
    </div>

    @livewire('modal.guild-features')
    @livewire('modal.guild-permissions')
    @livewire('modal.guild-experiments')
</div>
