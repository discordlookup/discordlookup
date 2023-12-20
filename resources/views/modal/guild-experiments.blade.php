<div>
    <div
        x-cloak
        x-show="modalExperimentsOpen"
        x-trap.noscroll="modalExperimentsOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-bind:aria-hidden="!modalExperimentsOpen"
        tabindex="-1"
        role="dialog"
        class="flex flex-col fixed inset-0 z-90 overflow-y-auto overflow-x-hidden bg-discord-gray-4 bg-opacity-75 p-4 backdrop-blur-sm lg:p-8"
    >
        <div
            x-cloak
            x-show="modalExperimentsOpen"
            @click.outside="modalExperimentsOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-125"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-125"
            role="document"
            class="m-auto flex w-full max-w-xl flex-col rounded-lg bg-discord-gray-1 shadow-sm"
        >
            <div class="flex items-center justify-between px-5 py-4">
                <h3 class="text-xl font-medium"><span class="font-bold">{{ __('Experiments') }}</span>: {{ $guildName }}</h3>
            </div>
            <div class="grow p-5 space-y-4">
                @if(empty($experiments))
                    {{ __('No experiments found.') }}
                @endif
                @foreach($experiments as $experiment)
                    <div>
                        <p class="font-semibold">
                            <a href="{{ route('experiments.show', $experiment['id']) }}" target="_blank" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                {{ $experiment['title'] }}
                            </a>
                        </p>
                        <p>{{ $experiment['treatment'] }}</p>
                        @if($experiment['override'])
                            <p class="text-green-400">({{ __('This Guild has an override for this experiment') }})</p>
                        @else
                            @foreach($experiment['filters'] as $filters)
                                <p class="text-gray-400">{{ $filters }}</p>
                            @endforeach
                        @endif
                        @if(!$loop->last)
                            <hr class="my-3 opacity-10" />
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="space-x-1 px-5 py-4 text-right">
                <button
                    x-on:click="modalExperimentsOpen = false"
                    type="button"
                    class="inline-flex items-center justify-center space-x-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm active:border-gray-200 active:shadow-none"
                >
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>
