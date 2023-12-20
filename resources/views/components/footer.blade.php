<div>
    <footer class="bg-discord-gray-1">
        <div class="container xl:max-w-7xl mx-auto px-4 py-8 lg:px-8 lg:py-16">
            <div class="flex flex-col md:flex-row-reverse md:justify-between space-y-6 md:space-y-0 text-center md:text-left text-sm">
                <nav class="space-x-4">
                    <a href="https://discord.gg/XsPcgeuEmB" target="_blank" rel="noopener" class="text-gray-400 hover:text-discord-blurple">
                        <i class="fab fa-discord text-2xl"></i>
                    </a>
                    <a href="https://github.com/discordlookup" target="_blank" rel="noopener" class="text-gray-400 hover:text-discord-blurple">
                        <i class="fab fa-github text-2xl"></i>
                    </a>
                    <a href="https://twitter.com/discordlookup" target="_blank" rel="noopener" class="text-gray-400 hover:text-discord-blurple">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                </nav>
                <div class="space-y-3">
                    <div class="text-gray-300 font-bold">&copy; {{ date('Y') }} {{ env('APP_NAME') }}</div>
                    <div class="text-gray-500">
                        {{ __('DiscordLookup is not affiliated, associated, authorized, endorsed by, or in anyway') }}<br>
                        {{ __('officially connected with Discord Inc., or any of its subsidiaries or its affiliates.') }}
                    </div>
                    <div class="text-gray-500">
                        {{ __('Commit') }}:
                        <a href="{{ env('GITHUB_URL') }}/commit/{{ getCurrentGitCommit() }}" target="_blank" rel="noopener">
                            {{ getCurrentGitCommit() }}
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-10 opacity-10" />

            <div class="text-center">
                <a class="text-gray-400" href="{{ route('legal.imprint') }}">{{ __('Imprint') }}</a>
                <a class="text-gray-400 ms-2" href="{{ route('legal.terms-of-service') }}">{{ __('Terms of Service') }}</a>
                <a class="text-gray-400 ms-2" href="{{ route('legal.privacy') }}">{{ __('Privacy Policy') }}</a>
            </div>
        </div>
    </footer>
</div>

{{--
<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="javascript:;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
        </a>
        <div class="dropdown-menu bg-dark">
            @foreach (Config::get('languages') as $lang => $language)
                <a class="dropdown-item text-white @if($lang == App::getLocale()) active @endif" href="{{ route('language.switch', $lang) }}"><span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
            @endforeach
        </div>
    </li>
</ul>
--}}
