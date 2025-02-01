@php
    $routes = [
        [
            'name' => __('Home'),
            'route' => 'home',
            'subRoutes' => []
        ],
        [
            'name' => __('Lookups'),
            'route' => '',
            'subRoutes' => [
                [
                    'name' =>  __('User Lookup'),
                    'route' => 'userlookup',
                ],
                [
                    'name' => __('Guild Lookup'),
                    'route' => 'guildlookup',
                ],
                [
                    'name' => __('Application Lookup'),
                    'route' => 'applicationlookup',
                ],
                [
                    'name' => __('Invite Resolver'),
                    'route' => 'inviteresolver',
                ],
            ]
        ],
        [
            'name' => __('Timestamps'),
            'route' => '',
            'subRoutes' => [
                [
                    'name' =>  __('Snowflake Decoder'),
                    'route' => 'snowflake',
                ],
                [
                    'name' => __('Timestamp Styles'),
                    'route' => 'timestamp',
                ],
                [
                    'name' => __('Snowflake Distance Calculator'),
                    'route' => 'snowflake-distance-calculator',
                ],
            ]
        ],
        [
            'name' => __('Guild List'),
            'route' => 'guildlist',
            'subRoutes' => []
        ],
        [
            'name' => __('Experiments'),
            'route' => 'experiments.index',
            'subRoutes' => []
        ],
        [
            'name' => __('Advanced'),
            'route' => '',
            'subRoutes' => [
                [
                    'name' =>  __('Permissions Calculator'),
                    'route' => 'permissions-calculator',
                ],
                [
                    'name' => __('Guild Shard Calculator'),
                    'route' => 'guild-shard-calculator',
                ],
                [
                    'name' => __('Discord Webhook Invalidator'),
                    'route' => 'webhook-invalidator',
                ],
                [
                    'name' => __('Bad Domain Check'),
                    'route' => 'domains',
                ],
                [
                    'name' => __('MurmurHash3 Calculator'),
                    'route' => 'murmurhash',
                ],
            ]
        ],
        [
            'name' => __('Help'),
            'route' => 'help',
            'subRoutes' => []
        ],
    ];
@endphp
<div>
    <header x-data="{ mobileNavOpen: false }" id="page-header" class="flex flex-none items-center py-6">
        <div class="container relative xl:max-w-7xl mx-auto px-4 lg:px-10">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 font-bold text-lg tracking-wide text-blue-600 hover:text-blue-400">
                    <img src="{{ asset('images/branding/logo-blurple.svg') }}" class="max-h-4" alt="{{ config('app.name') }} Logo" />
                </a>

                <ul class="hidden lg:flex items-center">
                    @foreach($routes as $route)
                        <li class="relative group">
                            <a
                                href="{{ $route['subRoutes'] ? 'javascript:;' : route($route['route']) }}"
                                class="inline-flex items-center space-x-1 h-8 px-4 text-white hover:text-gray-300 group-hover:text-gray-300 {{ (request()->routeIs($route['route']) || (is_array($route['subRoutes']) && collect($route['subRoutes'])->contains(fn($value, $key) => request()->routeIs($value['route'])))) ? 'font-bold' : 'font-semibold' }}"
                            >
                                <span>{{ $route['name'] }}</span>
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
                                                        <a
                                                            href="{{ route($subRoute['route']) }}"
                                                            class="flex items-center space-x-2 font-medium text-sm {{ request()->routeIs($subRoute['route']) ? 'text-discord-blurple active:text-[#414aa5]' : 'text-gray-200 hover:text-discord-blurple active:text-[#414aa5]' }}"
                                                        >
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

                <div class="flex">
                    @guest()
                        <a href="{{ route('login') }}" role="button" class="inline-flex justify-center items-center space-x-2 border font-semibold px-3 py-2 leading-5 text-sm rounded border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ __('Login') }}</span>
                        </a>
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
                                    <img src="{{ auth()->user()->avatarUrl }}" alt="User Avatar" class="inline-block h-4 w-4 flex-none rounded-full" />
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
                                            <img src="{{ auth()->user()->avatarUrl }}" alt="User Avatar" class="inline-block h-10 w-10 flex-none rounded-full" />
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

                    <div class="ml-3 lg:hidden">
                        <button
                            x-on:click="mobileNavOpen = true"
                            type="button"
                            class="inline-flex justify-center items-center space-x-2 border font-semibold px-3 py-2 leading-5 text-sm rounded border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                            aria-controls="mobileNav"
                        >
                            <svg class="hi-mini hi-bars-3 inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <nav
            x-cloak
            x-show="mobileNavOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-50 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-50 translate-x-full"
            id="mobileNav"
            class="fixed bottom-0 right-0 top-0 z-50 w-80 overflow-auto bg-discord-gray-1 shadow-lg lg:hidden outline-none"
            tabindex="-1"
            aria-labelledby="mobileNavLabel"
            x-bind:aria-modal="mobileNavOpen ? 'true' : null"
            x-bind:role="mobileNavOpen ? 'dialog' : null"
        >
            <div class="flex items-center justify-between p-6">
                <button
                    x-on:click="mobileNavOpen = false"
                    type="button"
                    class="inline-flex ml-auto justify-center items-center space-x-2 border font-semibold px-3 py-2 leading-5 text-sm rounded border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
                >
                    <svg class="hi-mini hi-x-mark -mx-0.5 inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                </button>
            </div>
            <hr class="opacity-10" />
            <div class="flex flex-col gap-4 px-6 py-6">
                @foreach($routes as $route)
                    <div class="space-y-2">
                        @if($route['subRoutes'])
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-discord-blurple">
                                {{ $route['name'] }}
                            </h4>
                            <nav class="flex flex-col gap-1">
                                @foreach($route['subRoutes'] as $subRoute)
                                    <a href="{{ route($subRoute['route']) }}" class="text-sm font-medium {{ request()->routeIs($subRoute['route']) ? 'text-white font-bold hover:text-gray-200 active:text-gray-300' : 'text-gray-400 hover:text-gray-200 active:text-gray-100' }}">
                                        {{ $subRoute['name'] }}
                                    </a>
                                @endforeach
                            </nav>
                        @else
                            <a href="{{ route($route['route']) }}" class="text-xs font-semibold uppercase tracking-wider  {{ request()->routeIs($route['route']) ? 'text-white font-bold hover:text-gray-200 active:text-gray-300' : 'text-gray-400 hover:text-gray-200 active:text-gray-100' }}">
                                {{ $route['name'] }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </nav>

        <div
            x-cloak
            x-show="mobileNavOpen"
            x-on:click="mobileNavOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-gray-900 bg-opacity-20 backdrop-blur-sm will-change-auto lg:hidden"
        ></div>
    </header>
</div>
