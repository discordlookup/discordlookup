@section('title', __('Guild Shard ID Calculator'))
@section('description', __('Calculate the Shard ID of a guild using the Guild ID and the total number of shards.'))
@section('keywords', 'bot shard, shards, calculator, shard calculator, shard id, guild id')
@section('robots', 'index, follow')

<div>
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Guild Shard ID Calculator') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-xl-4 offset-xl-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                    <input wire:model="guildId" class="form-control form-control-lg" type="text" placeholder="{{ __('Guild ID') }}">
                </div>
            </div>
            <div class="col-12 col-xl-2 mt-3 mt-xl-0">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="fas fa-server"></i>
                    </span>
                    <input wire:model="totalShards" class="form-control form-control-lg" type="text" placeholder="{{ __('Shards') }}">
                </div>
            </div>
            @if($errorMessage)
                <div class="col-12 col-xl-6 offset-xl-3 mt-3">
                    <div class="alert alert-danger fade show" role="alert">
                        {{ $errorMessage }}
                    </div>
                </div>
            @elseif($shardId !== null)
                <div class="col-12 col-xl-6 offset-xl-3 mt-3">
                    <div class="card text-white bg-dark">
                        <div class="card-body text-center">
                            <h2 class="fw-bold">{{ __('This Guild is on Shard ID') }} <span class="text-primary">{{ $shardId }}</span></h2>
                            <span class="small fst-italic">{{ __('The Shard ID is zero-based.') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
