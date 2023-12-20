@section('title', __('Application Lookup'))
@section('description', __('Get detailed information about Discord applications with description, links, tags and flags.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Application Lookup') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <x-input-prepend-icon icon="far fa-snowflake">
            <input
                wire:model.defer="snowflake"
                wire:keydown.enter="fetchApplication"
                type="number"
                placeholder="{{ __('Application ID') }}"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </x-input-prepend-icon>

        <button
            wire:click="fetchApplication"
            wire:loading.class="border-[#414aa5] bg-[#414aa5] cursor-not-allowed"
            wire:loading.class.remove="border-discord-blurple bg-discord-blurple hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
            wire:loading.attr="disabled"
            type="button"
            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            <span wire:loading.remove>{{ __('Fetch Discord Information') }}</span>
            <span wire:loading><i class="fas fa-spinner fa-spin"></i> {{ __('Fetching...') }}</span>
        </button>

        @if($errorMessage)
            <div class="col-12 col-lg-6 offset-lg-3 mt-3">
                <div class="alert alert-danger fade show" role="alert">
                    {{ $errorMessage }}
                </div>
            </div>
        @endif

        @if($rateLimitHit)
            <x-error-message>
                {{ __('You send too many requests!') }}
                @auth
                    {{ __('Please try again in :SECONDS seconds.', ['seconds' => $rateLimitAvailableIn ]) }}
                @endauth
                @guest
                    {{ __('Please try again in :SECONDS seconds or log in with your Discord account to increase the limit.', ['seconds' => $rateLimitAvailableIn ]) }}
                @endguest
            </x-error-message>
        @endif

        @if($applicationData == null && $fetched)
            <x-error-message>
                <p>{{ __('No Discord application could be found for the entered Snowflake.') }}</p>
                <p>{!! __('If you want to search for a :guild or :user instead, check out our other tools.', ['guild' => '<a href="' . route('guildlookup', ['snowflake' => $snowflake]) . '" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">guild</a>', 'user' => '<a href="' . route('userlookup', ['snowflake' => $snowflake]) . '" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">user</a>']) !!}</p>
            </x-error-message>
        @endif

        @if($applicationData)
            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
                    <div class="flex flex-col gap-y-5 md:gap-y-0.5 grow w-full">
                        <div class="grid grid-cols-1 md:grid-cols-8 gap-y-3">
                            <div class="col-span-1 text-center md:text-left my-auto">
                                <a href="{{ $applicationData['iconUrl'] }}" target="_blank">
                                    <img
                                        src="{{ $applicationData['iconUrl'] }}"
                                        loading="lazy"
                                        alt="application icon"
                                        class="inline-block w-16 h-16 rounded-full"
                                    />
                                </a>
                            </div>
                            <div class="col-span-4 text-center md:text-left my-auto">
                                <p class="font-semibold">{{ $applicationData['name'] }}</p>
                                <p class="text-gray-500 text-sm">{{ $applicationData['id'] }}</p>
                            </div>
                            @if($applicationData['coverImageUrl'])
                                <div class="col-span-3 text-center md:text-right my-auto">
                                    <a href="{{ $applicationData['coverImageUrl'] }}" target="_blank">
                                        <img
                                            src="{{ $applicationData['coverImageUrl'] }}"
                                            loading="lazy"
                                            alt="application cover"
                                            class="inline-block h-16 rounded-md"
                                        />
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-5 lg:p-6 grow w-full space-y-5">
                    @if($applicationData['descriptionFormatted'])
                        <div>
                            {!! $applicationData['descriptionFormatted'] !!}
                        </div>
                        <hr class="my-6 opacity-10" />
                    @endif

                    <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                        @if($applicationData['id'])
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Created') }}<span class="hidden md:inline">:</span></span>
                                <p>
                                    <a href="{{ route('timestamp', ['timestampSlug' => round(getTimestamp($applicationData['id']) / 1000)]) }}">
                                        {{ date('Y-m-d G:i:s \(T\)', getTimestamp($applicationData['id']) / 1000) }}
                                        <span class="text-sm">({{ \Carbon\Carbon::createFromTimestamp(getTimestamp($applicationData['id']) / 1000)->diffForHumans() }})</span>
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if($applicationData['guildId'])
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Linked Guild') }}<span class="hidden md:inline">:</span></span>
                                <p>
                                    <a href="{{ route('guildlookup', ['snowflake' => $applicationData['guildId']]) }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                        {{ $applicationData['guildId'] }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if(!is_null($applicationData['type']))
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Type') }}<span class="hidden md:inline">:</span></span>
                                <p>{{ $applicationData['type'] }}</p>
                            </div>
                        @endif

                        @if(!is_null($applicationData['hook']))
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Hook') }}<span class="hidden md:inline">:</span></span>
                                <p class="my-auto">
                                    @if($applicationData['hook'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                                    @endif
                                </p>
                            </div>
                        @endif

                        @if(!is_null($applicationData['botPublic']))
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Public Bot') }}<span class="hidden md:inline">:</span></span>
                                <p class="my-auto">
                                    @if($applicationData['botPublic'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                                    @endif
                                </p>
                            </div>
                        @endif

                        @if(!is_null($applicationData['botRequireCodeGrant']))
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <span class="font-semibold">{{ __('Requires OAuth2 Code Grant') }}<span class="hidden md:inline">:</span></span>
                                <p class="my-auto">
                                    @if($applicationData['botRequireCodeGrant'])
                                        <img src="{{ asset('images/discord/icons/check.svg') }}" class="h-4 w-4" alt="Check">
                                    @else
                                        <img src="{{ asset('images/discord/icons/cross.svg') }}" class="h-4 w-4" alt="Cross">
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>

                    @if($applicationData['customInstallUrl'] || $applicationData['roleConnectionsVerificationUrl'] || $applicationData['termsOfServiceUrl'] || $applicationData['privacyPolicyUrl'])
                        <div>
                            <div class="font-semibold">{{ __('Links') }}<span class="hidden md:inline">:</span></div>
                            <div>
                                <ul class="list-none capitalize">
                                    @if($applicationData['customInstallUrl'])
                                        <li>
                                            <a href="{{ $applicationData['customInstallUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ __('Custom Install Url') }}</a>
                                        </li>
                                    @endif

                                    @if($applicationData['roleConnectionsVerificationUrl'])
                                        <li>
                                            <a href="{{ $applicationData['roleConnectionsVerificationUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ __('Role Connections Verification Url') }}</a>
                                        </li>
                                    @endif

                                    @if($applicationData['termsOfServiceUrl'])
                                        <li>
                                            <a href="{{ $applicationData['termsOfServiceUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ __('Terms of Service') }}</a>
                                        </li>
                                    @endif

                                    @if($applicationData['privacyPolicyUrl'])
                                        <li>
                                            <a href="{{ $applicationData['privacyPolicyUrl'] }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ __('Privacy Policy') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(!empty($applicationData['tags']))
                        <div>
                            <div class="font-semibold">{{ __('Tags') }}<span class="hidden md:inline">:</span></div>
                            <div>
                                <ul class="list-inside list-disc capitalize">
                                    @foreach($applicationData['tags'] as $tag)
                                        <li>{{ $tag }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(!empty($applicationData['flagsList']))
                        <div>
                            <div class="font-semibold">{{ __('Flags') }}<span class="hidden md:inline">:</span></div>
                            <div>
                                <ul class="list-inside list-disc capitalize">
                                    @foreach($applicationData['flagsList'] as $flag)
                                        <li>{{ str_replace('_', ' ', strtolower($flag)) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($applicationData)
            <a role="button" href="{{ route('userlookup', ['snowflake' => $applicationData['id']]) }}" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
                {{ __('More information about this bot') }}
            </a>
        @endif
    </div>
</div>
