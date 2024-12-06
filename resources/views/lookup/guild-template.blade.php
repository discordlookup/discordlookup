<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Guild Template Lookup') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <x-input-prepend-icon icon="far fa-snowflake">
            <input
                wire:model.defer="snowflake"
                wire:keydown.enter="fetchApplication"
                type="number"
                placeholder="{{ __('Template Code') }}"
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

    </div>
</div>
