<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('MurmurHash3 Calculator') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-x-3 gap-y-3 md:gap-y-0">
            <div class="col-span-3">
                <x-input-prepend-icon icon="fas fa-hashtag">
                    <input
                        wire:model="text"
                        type="text"
                        placeholder="2024-04_clan_guilds:980791496833908778"
                        class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                        data-1p-ignore
                        autofocus
                    />
                </x-input-prepend-icon>
            </div>

            <label class="group relative inline-flex items-center gap-3">
                <input type="checkbox" class="peer sr-only" wire:model="mod10000"/>
                <span class="relative h-6 w-10 flex-none rounded-full bg-gray-500 transition-all duration-150 ease-out peer-checked:bg-discord-blurple peer-focus:ring-3 peer-focus:ring-discord-blurple/50 peer-focus:ring-offset-2 peer-focus:ring-offset-gray-900 peer-disabled:cursor-not-allowed peer-disabled:opacity-75 before:absolute before:top-1 before:left-1 before:size-4 before:rounded-full before:bg-white before:transition-transform before:duration-150 before:ease-out before:content-[''] peer-checked:before:translate-x-full"></span>
                <span class="text-sm font-medium">Mod 10000</span>
            </label>
        </div>

        <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
            <div class="p-5 lg:p-6 grow w-full space-y-4">
                <p class="font-mono text-sm">
                    {{ $murmurhash }}
                </p>
            </div>
        </div>
    </div>
</div>
