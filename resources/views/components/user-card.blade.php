<div>
    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
        @if(isset($title))
            <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                <h3 class="font-semibold">{{ $title }}</h3>
            </div>
        @endif

        <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
            <div class="mr-4">
                <a href="{{ $user['avatarUrl'] }}" target="_blank">
                    @if($user['avatarDecorationUrl'])
                        <img src="{{ $user['avatarDecorationUrl'] }}" loading="lazy" class="absolute user-avatar-decoration" width="80px" height="80px" alt="user avatar decoration">
                    @endif
                    <img
                        src="{{ $user['avatarUrl'] }}"
                        loading="lazy"
                        alt="User Avatar"
                        class="inline-block w-16 h-16 rounded-full"
                    />
                </a>
            </div>
            <div>
                <p class="font-semibold">
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
                        <p>
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
                                @endif
                            </span>
                        </p>
                        <p class="text-gray-500 text-sm">
                            {{ $user['id'] }}
                        </p>
            </div>
            @if($user['bannerUrl'])
                <div class="ml-auto">
                    <a href="{{ $user['bannerUrl'] }}" target="_blank">
                        <img
                            src="{{ $user['bannerUrl'] }}"
                            loading="lazy"
                            alt="User Banner"
                            class="inline-block h-16 rounded-md"
                        />
                    </a>
                </div>
            @endif
        </div>
        <div class="p-5 lg:p-6 grow w-full">
            <table class="min-w-full align-middle whitespace-nowrap">
                <tbody>

                @if($user['id'])
                    <tr>
                        <td class="font-semibold">{{ __('Created') }}:</td>
                        <td>
                            <a href="{{ route('timestamp', ['timestampSlug' => round(getTimestamp($user['id']) / 1000)]) }}">
                                {{ date('Y-m-d G:i:s \(T\)', getTimestamp($user['id']) / 1000) }}
                                <span class="text-sm">({{ \Carbon\Carbon::createFromTimestamp(getTimestamp($user['id']) / 1000)->diffForHumans() }})</span>
                            </a>
                        </td>
                    </tr>
                @endif

                <tr>
                    <td class="font-semibold">{{ __('Bot') }}:</td>
                    <td>
                        @if($user['isBot'])
                            <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check" />
                        @else
                            <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross" />
                        @endif
                    </td>
                </tr>

                @if($user['isBot'])
                    <tr>
                        <td class="font-semibold">{{ __('Verified Bot') }}:</td>
                        <td>
                            @if($user['isVerifiedBot'] || $user['id'] === '643945264868098049' || $user['id'] === '1081004946872352958')
                                <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                            @else
                                <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                            @endif
                        </td>
                    </tr>
                @endif

                @if($user['bannerColor'])
                    <tr>
                        <td class="font-semibold">{{ __('Banner Color') }}:</td>
                        <td>
                            <x-color-preview :hexColor="$user['bannerColor']" />
                        </td>
                    </tr>
                @endif

                @if($user['accentColor'])
                    <tr>
                        <td class="font-semibold">{{ __('Accent Color') }}:</td>
                        <td>
                            <x-color-preview :hexColor="$user['accentColor']" />
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>

            @if(!empty($user['flagsList']))
                <div class="mt-3 space-y-1">
                    <div class="font-semibold">{{ __('Badges') }}</div>
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
    @if($user['isBot'])
        <a role="button" href="{{ route('applicationlookup', $user['id']) }}" class="btn btn-primary w-100 mt-3">{{ __('More information about this application') }}</a>
    @endif
</div>
