<div>
    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
        @isset($title)
            <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                <h3 class="font-semibold">{{ $title }}</h3>
            </div>
        @endisset

        <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
            <div class="flex flex-col gap-y-5 md:gap-y-0.5 grow w-full">
                <div class="grid grid-cols-1 md:grid-cols-8 gap-y-3">
                    <div class="col-span-1 text-center md:text-left my-auto">
                        <a href="{{ $user['avatarUrl'] }}" target="_blank">
                            @if($user['avatarDecorationUrl'])
                                <img src="{{ $user['avatarDecorationUrl'] }}" loading="lazy" class="absolute user-avatar-decoration" width="80px" height="80px" alt="user avatar decoration">
                            @endif
                            <img src="{{ $user['avatarUrl'] }}" loading="lazy" alt="User Avatar" class="inline-block w-16 h-16 rounded-full" />
                        </a>
                    </div>
                    <div class="col-span-4 text-center md:text-left my-auto">
                        @if($user['discriminator'] === "0")
                            <p class="font-bold">{{ $user['global_name'] }}</p>
                            <p>&commat;{{ $user['username'] }}</p>
                        @else
                            @if($user['global_name'])
                                <p class="font-extrabold">{{ $user['global_name'] }}</p>
                                @endif
                                &commat;{{ $user['username'] }}<span class="text-gray-400 text-sm font-semibold">#{{ $user['discriminator'] }}</span>
                            @endif

                            @if($user['isBot'])
                                <span class="font-semibold inline-flex px-2 py-1 leading-3 text-sm rounded text-white bg-discord-blurple">
                                @if($user['isVerifiedBot'] || $user['id'] === '643945264868098049' || $user['id'] === '1081004946872352958')
                                        <i class="fas fa-check"></i>&nbsp;
                                    @endif
                                <span class="font-medium uppercase">
                                    @if($user['id'] === '643945264868098049')
                                        {{ __('System') }}
                                    @elseif($user['id'] === '1081004946872352958')
                                        {{ __('AI') }}
                                    @else
                                        {{ __('Bot') }}
                                    @endif
                                </span>
                            </span>
                        @endif
                        <p class="text-gray-500 text-sm">
                            {{ $user['id'] }}
                        </p>
                    </div>
                    @if($user['bannerUrl'])
                        <div class="col-span-3 text-center md:text-right my-auto">
                            <a href="{{ $user['bannerUrl'] }}" target="_blank">
                                <img src="{{ $user['bannerUrl'] }}" loading="lazy" alt="User Banner" class="inline-block h-16 rounded-md" />
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="p-5 lg:p-6 grow w-full">
            <div class="flex flex-col gap-y-5 md:gap-y-0.5 mb-5 md:mb-3">
                @if($user['id'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Created') }}<span class="hidden md:inline">:</span></span>
                        <p>
                            <a href="{{ route('timestamp', ['timestampSlug' => round(getTimestamp($user['id']) / 1000)]) }}">
                                {{ date('Y-m-d G:i:s \(T\)', getTimestamp($user['id']) / 1000) }}
                                <span class="text-sm">({{ \Carbon\Carbon::createFromTimestamp(getTimestamp($user['id']) / 1000)->diffForHumans() }})</span>
                            </a>
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Bot') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if($user['isBot'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check" />
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross" />
                        @endif
                    </p>
                </div>

                @if($user['isBot'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Verified Bot') }}<span class="hidden md:inline">:</span></span>
                        <p class="my-auto">
                            @if($user['isVerifiedBot'] || $user['id'] === '643945264868098049' || $user['id'] === '1081004946872352958')
                                <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                            @else
                                <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                            @endif
                        </p>
                    </div>
                @endif

                @if($user['bannerColor'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Banner Color') }}<span class="hidden md:inline">:</span></span>
                        <x-color-preview :hexColor="$user['bannerColor']" />
                    </div>
                @endif

                @if($user['accentColor'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Accent Color') }}<span class="hidden md:inline">:</span></span>
                        <x-color-preview :hexColor="$user['accentColor']" />
                    </div>
                @endif
            </div>

            @if(!empty($user['flagsList']))
                <div class="space-y-1">
                    <div class="font-semibold">{{ __('Badges') }}<span class="hidden md:inline">:</span></div>
                    <div>
                        <ul class="list-none space-y-1">
                            @if(array_key_exists('premiumType', $user) && $user['premiumType'] != null && $user['premiumType'] > 0)
                                <li class="flex space-x-2">
                                    <img src="{{ asset('images/discord/icons/badges/nitro.svg') }}" loading="lazy" height="18" width="18" alt="{{ $user['premiumTypeName'] }} Badge Icon" />
                                    <span>{{ $user['premiumTypeName'] }}</span>
                                </li>
                            @endif
                            @foreach($user['flagsList'] as $flag)
                                <li class="flex space-x-2">
                                    @if($flag['image'])
                                        <img src="{{ $flag['image'] }}" loading="lazy" height="18" width="18" alt="{{ $flag['name'] }} Badge Icon" />
                                    @endif
                                    <span>{{ $flag['name'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- TODO: top.gg API fetch for bots? --}}
        </div>
    </div>
</div>
