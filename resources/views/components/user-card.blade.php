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
                                @if($user['isVerifiedBot'] || $user['id'] === '643945264868098049' || $user['id'] === '1232523165893132288' || $user['id'] === '1081004946872352958')
                                        <i class="fas fa-check"></i>&nbsp;
                                    @endif
                                <span class="font-medium uppercase">
                                    @if($user['id'] === '643945264868098049' || $user['id'] === '1232523165893132288')
                                        {{ __('Official') }}
                                    @elseif($user['id'] === '1081004946872352958')
                                        {{ __('AI') }}
                                    @else
                                        {{ __('App') }}
                                    @endif
                                </span>
                            </span>
                        @endif
                        <p class="text-gray-500 text-sm">
                            <a href="https://discord.com/users/{{ $user['id'] }}" target="_blank">
                                {{ $user['id'] }}
                            </a>
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
                            @if($user['isVerifiedBot'] || $user['id'] === '643945264868098049' || $user['id'] === '1232523165893132288' || $user['id'] === '1081004946872352958')
                                <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                            @else
                                <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                            @endif
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Spammer') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if($user['isSpammer'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check" />
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross" />
                        @endif
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <span class="font-semibold">{{ __('Provisional Account') }}<span class="hidden md:inline">:</span></span>
                    <p class="my-auto">
                        @if($user['isProvisionalAccount'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check" />
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross" />
                        @endif
                    </p>
                </div>

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

                @if($user['avatarDecorationSku'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Avatar Decoration SKU ID') }}<span class="hidden md:inline">:</span></span>
                        <p>
                            <a href="https://discord.com/shop#itemSkuId={{ $user['avatarDecorationSku'] }}" target="_blank" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                {{ $user['avatarDecorationSku'] }}
                            </a>
                        </p>
                    </div>
                @endif

                @if($user['avatarDecorationSku'] && $user['avatarDecorationExpiresAtFormatted'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Avatar Decoration Expires') }}<span class="hidden md:inline">:</span></span>
                        <p>
                            {!! $user['avatarDecorationExpiresAtFormatted'] !!}
                        </p>
                    </div>
                @endif

                @if(array_key_exists('collectibles', $user) && array_key_exists('nameplate', $user['collectibles']) && $user['collectibles']['nameplate']['label'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Nameplate Label') }}<span class="hidden md:inline">:</span></span>
                        <p class="capitalize">
                            {{ strtolower(implode(' ', array_slice(explode('_', $user['collectibles']['nameplate']['label']), 2, -1))) }} ({{ $user['collectibles']['nameplate']['palette'] }})
                        </p>
                    </div>
                @endif

                @if(array_key_exists('collectibles', $user) && array_key_exists('nameplate', $user['collectibles']) && $user['collectibles']['nameplate']['sku_id'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Nameplate SKU ID') }}<span class="hidden md:inline">:</span></span>
                        <p>
                            <a href="https://discord.com/shop#itemSkuId={{ $user['collectibles']['nameplate']['sku_id'] }}" target="_blank" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                {{ $user['collectibles']['nameplate']['sku_id'] }}
                            </a>
                        </p>
                    </div>
                @endif

                @if(array_key_exists('primaryGuild', $user) && $user['primaryGuild'] && array_key_exists('tag', $user['primaryGuild']) && $user['primaryGuild']['tag'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Primary Guild Tag') }}<span class="hidden md:inline">:</span></span>
                        <p>
                            {{ $user['primaryGuild']['tag'] }}
                        </p>
                    </div>
                @endif

                @if(array_key_exists('primaryGuild', $user) && $user['primaryGuild'] && array_key_exists('identity_guild_id', $user['primaryGuild']) && $user['primaryGuild']['identity_guild_id'])
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <span class="font-semibold">{{ __('Primary Guild ID') }}<span class="hidden md:inline">:</span></span>
                        <p>
                            <a href="{{ route('guildlookup', ['snowflake' => $user['primaryGuild']['identity_guild_id']]) }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                {{ $user['primaryGuild']['identity_guild_id'] }}
                            </a>
                        </p>
                    </div>
                @endif
            </div>

            @if(!empty($user['flagsList']))
                <div class="space-y-1 mb-5 md:mb-3">
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

            @if(array_key_exists('collectibles', $user) && array_key_exists('nameplate', $user['collectibles']) && $user['collectibles']['nameplate']['asset'])
                <div class="space-y-1">
                    <div class="font-semibold">{{ __('Nameplate Preview') }}<span class="hidden md:inline">:</span></div>
                    <div>
                        <a href="https://cdn.discordapp.com/assets/collectibles/{{ $user['collectibles']['nameplate']['asset'] }}asset.webm" target="_blank">
                            <video class="border border-discord-gray-5 rounded-lg" loop autoplay muted>
                                <source src="https://cdn.discordapp.com/assets/collectibles/{{ $user['collectibles']['nameplate']['asset'] }}asset.webm" loading="lazy" type="video/webm" alt="{{ $user['collectibles']['nameplate']['label'] }} Nameplate">
                            </video>
                        </a>
                    </div>
                </div>
            @endif

            {{-- TODO: top.gg API fetch for bots? --}}
        </div>
    </div>
</div>
