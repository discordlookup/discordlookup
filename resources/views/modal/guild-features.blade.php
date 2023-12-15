<div>
    <div
        x-cloak
        x-show="modalFeaturesOpen"
        x-trap.noscroll="modalFeaturesOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-bind:aria-hidden="!modalFeaturesOpen"
        tabindex="-1"
        role="dialog"
        class="flex flex-col fixed inset-0 z-90 overflow-y-auto overflow-x-hidden bg-discord-gray-4 bg-opacity-75 p-4 backdrop-blur-sm lg:p-8"
    >
        <div
            x-cloak
            x-show="modalFeaturesOpen"
            @click.outside="modalFeaturesOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-125"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-125"
            role="document"
            class="m-auto flex w-full max-w-xl flex-col overflow-hidden rounded-lg bg-discord-gray-1 shadow-sm"
        >
            <div class="flex items-center justify-between px-5 py-4">
                <h3 class="text-xl font-medium"><span class="font-bold">{{ __('Features') }}</span>: {{ $guildName }}</h3>
            </div>
            <div class="grow p-5">
                <ul class="list-inside list-disc capitalize">
                    @if(empty($features))
                        {{ __('No features') }}
                    @endif
                    @foreach($features as $feature)
                        <li>{{ strtolower(str_replace('_', ' ', $feature)) }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="space-x-1 px-5 py-4 text-right">
                <button
                    x-on:click="modalFeaturesOpen = false"
                    type="button"
                    class="inline-flex items-center justify-center space-x-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm active:border-gray-200 active:shadow-none"
                >
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>
