@php
    $routes = [
        [
            'name' => __('Home'),
            'route' => route('home'),
            'subRoutes' => []
        ],
        [
            'name' => __('Lookups'),
            'route' => '',
            'subRoutes' => [
                [
                    'name' =>  __('User Lookup'),
                    'route' => route('userlookup'),
                ],
                [
                    'name' => __('Guild Lookup'),
                    'route' => route('guildlookup'),
                ],
                [
                    'name' => __('Application Lookup'),
                    'route' => route('applicationlookup'),
                ],
                [
                    'name' => __('Invite Resolver'),
                    'route' => route('inviteresolver'),
                ],
            ]
        ],
        [
            'name' => __('Timestamps'),
            'route' => '',
            'subRoutes' => [
                [
                    'name' =>  __('Snowflake Decoder'),
                    'route' => route('snowflake'),
                ],
                [
                    'name' => __('Timestamp Styles'),
                    'route' => route('timestamp'),
                ],
                [
                    'name' => __('Snowflake Distance Calculator'),
                    'route' => route('snowflake-distance-calculator'),
                ],
            ]
        ],
        [
            'name' => __('Guild List'),
            'route' => route('guildlist'),
            'subRoutes' => []
        ],
        [
            'name' => __('Experiments'),
            'route' => route('experiments.index'),
            'subRoutes' => []
        ],
        [
            'name' => __('Advanced'),
            'route' => '',
            'subRoutes' => [
                [
                    'name' =>  __('Permissions Calculator'),
                    'route' => route('permissions-calculator'),
                ],
                [
                    'name' => __('Guild Shard Calculator'),
                    'route' => route('guild-shard-calculator'),
                ],
                [
                    'name' => __('Discord Webhook Invalidator'),
                    'route' => route('webhook-invalidator'),
                ],
            ]
        ],
        [
            'name' => __('Help'),
            'route' => route('help'),
            'subRoutes' => []
        ],
    ];
@endphp
<div>
    <header id="page-header" class="flex flex-none items-center py-6">
        <div class="relative container xl:max-w-7xl mx-auto px-4 lg:px-10">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 font-bold text-lg tracking-wide text-blue-600 hover:text-blue-400">
                    <img src="{{ asset('images/branding/logo-blurple.svg') }}" class="max-h-4" alt="{{ env('APP_NAME') }} Logo" />
                </a>

                <ul class="hidden lg:flex items-center">
                    @foreach($routes as $route)
                        <li class="relative group">
                            <a href="{{ $route['route'] }}" class="font-semibold inline-flex items-center space-x-1 h-8 px-4 group-hover:text-gray-300 text-white hover:text-gray-300">
                                <span class="font-semibold">{{ $route['name'] }}</span>
                                @if($route['subRoutes'])
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="opacity-50 transform transition duration-200 ease-out group-hover:rotate-180 hi-solid hi-chevron-down inline-block w-4 h-4"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                @endif
                            </a>
                            @if($route['subRoutes'])
                                <div class="absolute w-64 top-8 left-1/2 -ml-24 z-50 pt-5 invisible group-hover:visible">
                                    <div class="bg-discord-gray-1 shadow-sm shadow-gray-900 ring-1 ring-black ring-opacity-5 rounded-lg transform origin-top transition duration-300 ease-out opacity-0 scale-75 group-hover:opacity-100 group-hover:scale-100 overflow-hidden">
                                        <div class="grid grid-cols-1 transform transition duration-500 ease-out opacity-0 scale-90 group-hover:opacity-100 group-hover:scale-100">
                                            <div class="p-6 space-y-6">
                                                <nav class="flex flex-col space-y-3">
                                                    @foreach($route['subRoutes'] as $subRoute)
                                                        <a href="{{ $subRoute['route'] }}" class="flex items-center space-x-2 text-gray-200 hover:text-discord-blurple font-medium text-sm">
                                                            {{ $subRoute['name'] }}
                                                        </a>
                                                    @endforeach
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @guest()
                    <div class="hidden lg:flex items-center justify-center space-x-1 sm:space-x-2">
                        <a href="{{ route('login') }}" role="button" class="inline-flex justify-center items-center space-x-2 border font-semibold px-3 py-2 leading-5 text-sm rounded border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ __('Login') }}</span>
                        </a>
                    </div>
                @endguest
                @auth()
                    <div class="flex justify-end">
                        <div x-data="{ open: false }" class="relative inline-block">
                            <button
                                type="button"
                                class="inline-flex justify-center items-center space-x-2 border font-semibold px-3 py-2 leading-5 text-sm rounded border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                                id="usermenu-dropdown"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open"
                                x-on:click="open = true"
                            >
                                <span>{{ auth()->user()->displayName }}</span>
                                <svg class="hi-mini hi-chevron-down inline-block h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                            </button>

                            <div
                                x-cloak
                                x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90"
                                x-on:click.outside="open = false"
                                role="menu"
                                aria-labelledby="usermenu-dropdown"
                                class="absolute right-0 z-10 mt-2 w-64 origin-top-right rounded-lg shadow-sm shadow-gray-900"
                            >
                                <div class="divide-y divide-discord-gray-5 rounded-lg bg-discord-gray-1 ring-1 ring-gray-700 ring-opacity-5">
                                    <div class="flex items-center space-x-3 px-5 py-3">
                                        <img src="{{ auth()->user()->avatarUrl }}" alt="User Avatar" class="inline-block h-10 w-10 flex-none rounded-full"/>
                                        <div class="grow text-sm">
                                            <a href="{{ route('userlookup', auth()->user()->discord_id) }}" class="font-semibold text-gray-300 hover:text-gray-400">
                                                {{ auth()->user()->displayName }}
                                            </a>
                                            <p class="break-all text-xs font-medium text-gray-400">
                                                &commat;{{ auth()->user()->username }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-1 p-2.5">
                                        {{--
                                        <a role="menuitem" href="javascript:void(0)" class="group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-200 hover:bg-discord-gray-3 hover:text-white active:border-gray-600">
                                            <i class="fas fa-cogs w-5 flex-none opacity-25 group-hover:opacity-50"></i>
                                            <span class="grow">{{ __('Settings') }}</span>
                                        </a>
                                        --}}
                                        <a
                                            role="menuitem" href="{{ route('logout') }}" class="group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-200 hover:bg-discord-gray-3 hover:text-white active:border-gray-600">
                                            <i class="fas fa-sign-in-alt w-5 flex-none opacity-25 group-hover:opacity-50"></i>
                                            <span class="grow">{{ __('Logout') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </header>
</div>
