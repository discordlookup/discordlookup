<div>
    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
        <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4">
            <h3 class="font-semibold">{{ __('Login') }}</h3>
        </div>
        <div class="p-5 lg:p-6 grow w-full">
            <div class="flex flex-col gap-y-5 md:gap-y-0.5">
                <p>{{ __('To get an overview and stats about your guilds you need to log in with Discord.') }}</p>
                <p>{!! __('This website is open source on :github.', ['github' => '<a href="' . env('GITHUB_URL') . '" target="_blank">GitHub</a>']) !!}</p>
                <a role="button" class="btn btn-info mt-3" href="{{ route('login') }}" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
            </div>
        </div>
    </div>
</div>
