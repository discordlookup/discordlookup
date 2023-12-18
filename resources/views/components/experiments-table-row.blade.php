<div class="grid grid-cols-1 md:grid-cols-12 gap-y-3 md:gap-y-0 {deleted ? 'opacity-50' : ''}">
    <div class="col-span-1 inline-flex items-center justify-center">
        <i class="{{ $type == 'user' ? 'fas fa-user' : ($type == 'guild' ? 'fas fa-server' : 'fas fa-question') }} text-5xl text-discord-gray-5"></i>
    </div>
    <div class="col-span-9 text-center md:text-left">
        <p>{{ $title }}</p>
        <p class="text-gray-500 text-sm">
            {{ $id }}
            @if($updated)
                &bull; {{ date('Y-m-d g:i A', strtotime($updated)) }}
            @endif
        </p>
    </div>
    <div class="col-span-2 text-center md:text-right">
        @if($type == 'guild')
        <a role="button"
           href="{{ route('experiments.show', ['experimentId' => $id]) }}#guilds"
           class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            {{ __('Guilds') }}
        </a>
        @endif
        <a role="button"
           href="{{ route('experiments.show', ['experimentId' => $id]) }}"
           class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            {{ __('Experiment Info') }}
        </a>
    </div>
</div>
