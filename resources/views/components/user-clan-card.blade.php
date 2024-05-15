<div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
    @isset($title)
        <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
            <h3 class="font-semibold">{{ $title }}</h3>
        </div>
    @endisset

    @if(array_key_exists('name', $clan) && $clan['name'])
        <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
            <div class="flex flex-col gap-y-5 md:gap-y-0.5 grow w-full">
                <div class="grid grid-cols-1 md:grid-cols-8 gap-y-3">
                    <div class="col-span-1 text-center md:text-left my-auto">
                        @if(array_key_exists('iconUrl', $clan) && $clan['iconUrl'])
                            <a href="{{ $clan['iconUrl'] }}" target="_blank">
                                <img src="{{ $clan['iconUrl'] }}" loading="lazy" alt="Clan Icon" class="inline-block w-16 h-16 rounded-full"/>
                            </a>
                        @endif
                    </div>
                    <div class="col-span-4 text-center md:text-left my-auto">
                        <p>
                            <span class="font-semibold">{{ $clan['name'] }}</span>
                            <span class="font-semibold inline-flex px-2 py-1 leading-3 text-sm rounded text-white bg-discord-gray-5 space-x-1">
                                <a href="{{ $clan['badgeUrl'] }}" target="_blank">
                                    <img src="{{ $clan['badgeUrl'] }}" loading="lazy" alt="Clan Badge" class="inline-block w-4 h-4"/>
                                </a>
                                <span class="font-medium uppercase my-auto">
                                    {{ $clan['tag'] }}
                                </span>
                            </span>
                        </p>
                        <p>
                            @if(array_key_exists('memberCount', $clan) && $clan['memberCount'])
                                <span class="inline-block h-2 w-2 rounded-full bg-[#747f8d] mb-px mr-0.5"></span>
                                <span class="text-sm">{{ number_format($clan['memberCount'], 0, '', '.') }} {{ __('Members') }}</span>
                            @endif
                        </p>
                    </div>
                    @if(array_key_exists('bannerUrl', $clan) && $clan['bannerUrl'])
                        <div class="col-span-3 text-center md:text-right my-auto">
                            <a href="{{ $clan['bannerUrl'] }}" target="_blank">
                                <img
                                    src="{{ $clan['bannerUrl'] }}"
                                    loading="lazy"
                                    alt="Clan Banner"
                                    class="inline-block h-16 rounded-md"
                                />
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="p-5 lg:p-6 grow w-full">
        @if(array_key_exists('description', $clan) && $clan['description'])
            <div class="mb-5">
                {{ $clan['description'] }}
            </div>
            <hr class="my-6 opacity-10"/>
        @endif
        <div class="flex flex-col gap-y-5 md:gap-y-0.5 mb-5 md:mb-0">
            @if($clan['id'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Created') }}<span class="hidden md:inline">:</span></span>
                    <p>
                        <a href="{{ route('timestamp', ['timestampSlug' => round(getTimestamp($clan['id']) / 1000)]) }}">
                            {{ date('Y-m-d G:i:s \(T\)', getTimestamp($clan['id']) / 1000) }}
                            <span class="text-sm">({{ \Carbon\Carbon::createFromTimestamp(getTimestamp($clan['id']) / 1000)->diffForHumans() }})</span>
                        </a>
                    </p>
                </div>
            @endif

            @if(array_key_exists('id', $clan) && $clan['id'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Guild ID') }}<span class="hidden md:inline">:</span></span>
                    <p>
                        <a href="{{ route('guildlookup', ['snowflake' => $clan['id']]) }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                            {{ $clan['id'] }}
                        </a>
                    </p>
                </div>
            @endif

            @if(array_key_exists('playstyle', $clan) && $clan['playstyle'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Playstyle') }}<span class="hidden md:inline">:</span></span>
                    <p>
                        {{ $clan['playstyleName'] }} ({{ $clan['playstyle'] }})
                    </p>
                </div>
            @endif

            @if($clan['badgeColorPrimary'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Primary Badge Color') }}<span class="hidden md:inline">:</span></span>
                    <x-color-preview :hexColor="$clan['badgeColorPrimary']" />
                </div>
            @endif

            @if($clan['badgeColorSecondary'])
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Secondary Badge Color') }}<span class="hidden md:inline">:</span></span>
                    <x-color-preview :hexColor="$clan['badgeColorSecondary']" />
                </div>
            @endif
        </div>
        <div class="space-y-5 md:space-y-0.5">
            @if(array_key_exists('searchTerms', $clan) && !empty($clan['searchTerms']))
                <div>
                    <div class="font-semibold">{{ __('Search Terms') }}<span class="hidden md:inline">:</span></div>
                    <div>
                        <ul class="list-inside list-disc capitalize">
                            @foreach($clan['searchTerms'] as $searchTerm)
                                <li>{{ $searchTerm }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if(array_key_exists('wildcardDescriptors', $clan) && !empty($clan['wildcardDescriptors']))
                <div>
                    <div class="font-semibold">{{ __('Wildcard Descriptors') }}<span class="hidden md:inline">:</span></div>
                    <div>
                        <ul class="list-inside list-disc capitalize">
                            @foreach($clan['wildcardDescriptors'] as $wildcardDescriptor)
                                <li>{{ $wildcardDescriptor }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if(array_key_exists('gameIds', $clan) && !empty($clan['gameIds']))
                <div>
                    <div class="font-semibold">{{ __('Game IDs') }}<span class="hidden md:inline">:</span></div>
                    <div>
                        <ul class="list-inside list-disc capitalize">
                            @foreach($clan['gameIds'] as $gameId)
                                <li>{{ $gameId }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
