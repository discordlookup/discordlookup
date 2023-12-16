<div class="grid grid-cols-1 md:grid-cols-9 gap-y-3 md:gap-y-0 {deleted ? 'opacity-50' : ''}">
    <div class="col-span-1 inline-flex items-center justify-center">
        @if($type == 'user')
            <i class="fas fa-user text-5xl text-discord-blurple"></i>
        @elseif($type == 'guild')
            <i class="fas fa-server text-5xl text-discord-green"></i>
        @else
            <i class="fas fa-question text-5xl text-discord-red"></i>
        @endif
    </div>
    <div class="col-span-6 text-center md:text-left">
        <p>{{ $title }}</p>
        <p class="text-gray-500 text-sm">
            {{ $id }} &bull; {{ date('Y-m-d g:i A', strtotime($updated)) }}
        </p>
    </div>
    <div class="col-span-2 text-right">
        @if($type == 'guild')
        <a
            href="{{ route('experiments.show', ['experimentId' => $experiment['id']]) }}#guilds"
            class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-2 py-1 leading-5 text-sm border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200"
        >
            {{ __('Guilds') }}
        </a>
        @endif
        <a
            href="{{ route('experiments.show', ['experimentId' => $experiment['id']]) }}"
            class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-2 py-1 leading-5 text-sm border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200"
        >
            {{ __('Experiment Info') }}
        </a>
    </div>
</div>
