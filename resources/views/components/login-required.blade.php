<div {{ $attributes->merge(['class' => 'flex flex-col mx-auto rounded shadow-sm bg-discord-gray-1 overflow-hidden']) }}>
    <div class="p-5 lg:p-6 grow w-full">
        <div class="flex flex-col gap-y-5 md:gap-y-0.5 space-y-3 text-center">
            <h3 class="text-3xl font-bold">{{ __('Login Required') }}</h3>
            <div>
                <p>{{ __('To get an overview and stats about your guilds you need to log in with Discord.') }}</p>
                <p>{!! __('This website is open source on :github.', ['github' => '<a href="' . env('GITHUB_URL') . '" target="_blank" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">GitHub</a>']) !!}</p>
            </div>
            <a role="button" href="{{ route('login') }}" class="inline-flex mx-auto justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-32 border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
                <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
            </a>
        </div>
    </div>
</div>
