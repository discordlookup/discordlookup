@section('title', __('Guild Shard ID Calculator'))
@section('description', __('Calculate the Shard ID of a guild using the Guild ID and the total number of shards.'))
@section('keywords', 'bot shard, shards, calculator, shard calculator, shard id, guild id')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Guild Shard ID Calculator') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-4 space-x-0 md:space-x-2 space-y-2 md:space-y-0">
            <div class="col-span-3">
                <x-input-prepend-icon icon="far fa-snowflake">
                    <input
                        wire:model="guildIdDisplay"
                        type="number"
                        placeholder="{{ __('Guild ID') }}"
                        class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                    />
                </x-input-prepend-icon>
            </div>
            <div class="col-span-1">
                <x-input-prepend-icon icon="fas fa-server">
                    <input
                        wire:model="totalShards"
                        type="number"
                        min="1"
                        placeholder="{{ __('Shards') }}"
                        class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                    />
                </x-input-prepend-icon>
            </div>
        </div>

        @if($errorMessage)
            <x-error-message>
                {{ $errorMessage }}
            </x-error-message>
        @elseif($shardId !== null)
            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                <div class="p-5 lg:p-6 grow w-full text-center">
                    <p class="text-3xl font-bold">
                        {{ __('This Guild is on Shard ID') }} <span class="text-discord-blurple font-bold">{{ $shardId }}</span>
                    </p>
                    <p class="italic">{{ __('The Shard ID is zero-based.') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
