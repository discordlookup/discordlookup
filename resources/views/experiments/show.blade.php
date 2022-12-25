@if($experiment)
    @section('title', "{$experiment['name']} Experiment")
    @section('description', "Information and rollout status about the {$experiment['name']} Experiment.")
    @section('keywords', "client, guild, experiments, discord experiments, rollout, rollouts, treatments, groups, overrides, population, {$experiment['id']}")
    @section('robots', 'index, follow')

    <div id="experiment">
        <h1 class="mb-1 mt-5 text-center text-white">{{ $experiment['name'] }}</h1>
        <h4 class="mb-4 text-center text-muted">{{ $experiment['id'] }} ({{ $experiment['hash'] }})</h4>
        <div class="mt-2 mb-4">
            <div class="row mb-4">
                <div class="col-12 col-lg-10 offset-lg-1">
                    <div class="card text-white bg-dark border-0">
                        <div class="card-header">
                            <h1 class="m-0">
                                {{ __('Treatments') }}
                                <i class="far fa-question-circle text-muted align-middle" style="font-size: 0.5em !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Different versions of the experiment that can be activated') }}"></i>
                            </h1>
                        </div>
                        <div class="card-body">
                            @foreach($buckets as $bucket)
                                <h5 class="mb-3 text-primary">
                                    {{ $bucket['name'] }}
                                    <small class="text-white-50">{!! ($bucket['description'] ? : '<i>' . __('No description') . '</i>') !!}</small>
                                </h5>
                                @if($overrides && array_key_exists($bucket['id'], $overrides))
                                    <div>
                                        <b>{{ __('Overrides') }} ({{ sizeof($overrides[$bucket['id']]) }})</b> <i class="far fa-question-circle text-muted small align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Server that have the treatment in any case') }}"></i><br>
                                        @foreach($overrides[$bucket['id']] as $override)
                                            @if($loop->index == 12)
                                                <span class="badge bg-primary" style="cursor: pointer;" onclick="document.getElementById('allOverrides{{ $bucket['id'] }}').style.display = '';this.style.display = 'none';">
                                                    {{ __('Show all') }}
                                                </span>
                                                <span id="allOverrides{{ $bucket['id'] }}" style="display: none">
                                            @endif
                                            <a href="{{ route('guildlookup', ['snowflake' => $override]) }}"
                                               class="text-decoration-none" rel="nofollow">
                                                <span class="badge bg-body">{{ $override }}</span>
                                            </a>
                                            @if($loop->last)</span>@endif
                                        @endforeach
                                        <br>
                                    </div>
                                @endif
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @foreach($rollouts as $rollout)
                <div class="row mb-3">
                    <div class="col-12 col-lg-10 offset-lg-1">
                        <div class="card text-white bg-dark border-0">
                            <div class="card-body">
                                @if($rollout['filters'])
                                <span class="text-primary fw-bold">{{ __('Filter') }}:</span><br>
                                <ul class="lh-1">
                                    @foreach($rollout['filters'] as $filter)
                                        <li class="mt-2">
                                            <span class="text-white">{{ $filter }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                                @endif
                                @foreach($rollout['buckets'] as $bucket)
                                    @php($bucketInfo = $buckets["BUCKET {$bucket['id']}"] ?? ['id' => -1, 'name' => 'None', 'description' => ''])
                                    <div>
                                        @if($bucketInfo['name'] == 'None' || $bucketInfo['name'] == 'Control')
                                            <span class="text-danger fw-semibold">{{ $bucketInfo['name'] }}</span>
                                        @else
                                            <span class="text-success fw-semibold">{{ $bucketInfo['name'] }}</span>
                                        @endif

                                        <span class="text-white-50">
                                            {{ $bucketInfo['description'] }}@if($bucketInfo['description']):
                                            @endif
                                            <b>{{ $bucket['count'] / (10000)*100 }}&percnt;</b>
                                            @if($bucket['groups'])
                                                <span class="small">
                                                    @foreach($bucket['groups'] as $group)
                                                        @if($loop->first)(@endif{{ $group['start'] }} - {{ $group['end'] }}@if($loop->last))@else, @endif
                                                    @endforeach()
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($experiment['type'] == 'guild' && $experiment['rollout'])
                <div class="row mt-5">
                    <div class="col-12 col-lg-10 offset-lg-1">
                        <div class="card text-white bg-dark border-0">
                            <div class="card-header">
                                <h1 class="m-0" id="guilds">
                                    {{ __('Guilds') }}
                                    <i class="far fa-question-circle text-muted align-middle" style="font-size: 0.5em !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('List of all guilds you are on, which have this experiment') }}"></i>
                                </h1>
                            </div>
                            <div class="card-body">
                                @guest
                                    <div class="text-center">
                                        <h4>{{ __('To get experiment infos about your guilds you need to log in with Discord.') }}</h4>
                                        <h5>{!! __('This website is open source on :github.', ['github' => '<a href="' . env('GITHUB_URL') . '" target="_blank">GitHub</a>']) !!}</h5>
                                        <a role="button" class="btn btn-info mt-3" href="{{ route('login') }}" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                                    </div>
                                @endguest
                                @auth
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <select wire:model="treatment" class="form-select">
                                                @foreach($buckets as $bucket)
                                                    <option value="{{ $bucket['id'] }}">{{ $bucket['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 mt-2 mt-md-0">
                                            <select wire:model="sorting" class="form-select">
                                                <option value="name-asc" selected>{{ __('Name Ascending') }}</option>
                                                <option value="name-desc">{{ __('Name Descending') }}</option>
                                                <option value="id-asc">{{ __('Created Ascending') }}</option>
                                                <option value="id-desc">{{ __('Created Descending') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    @if(empty($guilds))
                                        <div>{{ __('No Guild found.') }}</div>
                                    @endif
                                    @foreach($guilds as $guildTreatments)
                                        @php($guild = $guildTreatments['guild'])
                                        <div class="row">
                                            <div class="col-12 col-md-1 text-center">
                                                @if($guild['icon'])
                                                    <a href="https://cdn.discordapp.com/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}" target="_blank">
                                                        <img src="https://cdn.discordapp.com/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}?size=128" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                                    </a>
                                                @else
                                                    <img src="https://cdn.discordapp.com/embed/avatars/0.png" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-6 text-center text-md-start">
                                                <div>
                                                    {{ $guild['name'] }}
                                                    @if($guild['owner']) {!! getDiscordBadgeServerIcons('owner', __('You own')) !!}
                                                    @elseif(hasAdministrator($guild['permissions'])) {!! getDiscordBadgeServerIcons('administrator', __('You administrate')) !!}
                                                    @elseif(hasModerator($guild['permissions'])) {!! getDiscordBadgeServerIcons('moderator', __('You moderate')) !!} @endif
                                                    @if(in_array('VERIFIED', $guild['features'])) {!! getDiscordBadgeServerIcons('verified', __('Discord Verified')) !!} @endif
                                                    @if(in_array('PARTNERED', $guild['features'])) {!! getDiscordBadgeServerIcons('partner', __('Discord Partner')) !!} @endif
                                                </div>
                                                <div class="mt-n1">
                                                    <small class="text-muted">
                                                        {{ $guild['id'] }} &bull; {{ date('Y-m-d', getTimestamp($guild['id']) / 1000) }}
                                                    </small>
                                                </div>
                                                @if($guildTreatments['override'])
                                                    <div class="mt-n1">
                                                        <small class="text-success">({{ __('This Guild has an override for this experiment') }})</small>
                                                    </div>
                                                @else
                                                    <div class="mt-n1">
                                                        <small class="text-muted">
                                                            @foreach($guildTreatments['filters'] as $filter)
                                                                {{ $filter }}
                                                            @endforeach
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-5 text-center text-md-end">
                                                <a role="button" href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}" rel="nofollow" class="btn btn-sm btn-outline-primary mt-2 mt-xl-0">{{ __('Guild Info') }}</a>
                                                <button wire:click="$emitTo('modal.guild-features', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-success mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalFeatures">{{ __('Features') }}</button>
                                                <button wire:click="$emitTo('modal.guild-permissions', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')" class="btn btn-sm btn-outline-danger mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalPermissions">{{ __('Permissions') }}</button>
                                                <button wire:click="$emitTo('modal.guild-experiments', 'update', '{{ $guild['id'] }}', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-warning mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalExperiments">{{ __('Experiments') }}</button>
                                            </div>
                                        </div>
                                        @if(!$loop->last)<hr>@endif
                                    @endforeach
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                $(function () {
                    $('[data-bs-toggle="tooltip"]').tooltip()
                })
                Livewire.hook('message.processed', (message, component) => {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip()
                    })
                })
            })
        </script>

        @livewire('modal.guild-features')
        @livewire('modal.guild-permissions')
        @livewire('modal.guild-experiments')
    </div>
@else
    <div>
        <h1 class="mb-1 mt-5 text-center text-white">
            {{ __('The page could not be loaded! Please try again.') }}
        </h1>
    </div>
@endif
