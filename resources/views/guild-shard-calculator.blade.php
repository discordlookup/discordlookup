@extends('layouts.app')

@section('title', __('Guild Shard ID Calculator'))
@section('description', __('Calculate the Shard ID of a guild using the Guild ID and the total number of shards.'))
@section('keywords', 'bot shard, shards, calculator, shard calculator, shard id, guild id')
@section('robots', 'index, follow')

@section('content')
    <div class="container">

        <h1 class="mb-4 mt-5 text-center text-white">{{ __('Guild Shard ID Calculator') }}</h1>
        <div class="mt-2 mb-4">
            <div class="row">

                <div class="col-12 col-xl-4 offset-xl-3">
                    <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="fas fa-fingerprint"></i>
                    </span>
                        <input id="guildIdInput" class="form-control form-control-lg" type="text" placeholder="{{ __('Guild ID') }}" value="{{ $guildId }}" oninput="update();" onchange="update();" onkeyup="update();">
                    </div>
                </div>
                <div class="col-12 col-xl-2 mt-3 mt-xl-0">
                    <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="fas fa-server"></i>
                    </span>
                        <input id="totalShardsInput" class="form-control form-control-lg" type="text" placeholder="{{ __('Shards') }}" value="{{ $totalShards }}" oninput="update();" onchange="update();" onkeyup="update();">
                    </div>
                </div>

                <div id="invalidInput" class="col-12 col-xl-6 offset-xl-3 mt-3" style="display: none;">
                    <div id="invalidInputMessage" class="alert alert-danger fade show" role="alert"></div>
                </div>

                <div id="infoCard" class="col-12 col-xl-6 offset-xl-3 mt-3" style="display: none;">
                    <div class="card text-white bg-dark">
                        <div class="card-body text-center">
                            <h2 class="fw-bold">{{ __('This Guild is on Shard ID') }} <span id="shardId" class="text-primary"></span></h2>
                            <small><i>The Shard ID is zero-based.</i></small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @push('scripts')
            <script>
                window.onload = function() {
                    update();
                };

                function update() {
                    var guildIdInput = document.getElementById('guildIdInput');
                    var guildIdInputValue = guildIdInput.value;
                    var totalShardsInput = document.getElementById('totalShardsInput');
                    var totalShardsInputValue = totalShardsInput.value;
                    var infoCard = document.getElementById('infoCard');
                    var date = validateSnowflake(guildIdInputValue);

                    document.getElementById('invalidInput').style.display = 'none';

                    if(guildIdInputValue !== "" && totalShardsInputValue !== "" && !date.toString().startsWith("That") && Number.isInteger(+totalShardsInputValue)) {
                        document.getElementById('shardId').innerText = getShardId(guildIdInputValue, totalShardsInputValue);
                        infoCard.style.display = '';
                    }else{
                        infoCard.style.display = 'none';
                        if(guildIdInputValue.length > 0 && date.toString().startsWith("That")) {
                            document.getElementById('invalidInputMessage').innerText = date;
                            document.getElementById('invalidInput').style.display = '';
                        }else if(!Number.isInteger(+totalShardsInputValue)) {
                            document.getElementById('invalidInputMessage').innerText = "Total Shards must be a valid number!";
                            document.getElementById('invalidInput').style.display = '';
                        }
                    }
                }

                function getShardId(guildId, totalShards) {
                    return parseInt(parseInt(guildId).toString(2).slice(0, -22), 2) % parseInt(totalShards);
                }
            </script>
        @endpush

    </div>
@endsection
