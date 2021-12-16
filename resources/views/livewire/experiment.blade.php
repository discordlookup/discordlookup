@section('title', "{$this->experiment['name']} Experiment")
@section('description', "Information and rollout status about the {$this->experiment['name']} Experiment.")
@section('keywords', "client, guild, experiments, discord experiments, rollout, rollouts, treatments, groups, overrides, population, {$this->experiment['id']}")

<div id="experiment">
    <h1 class="mb-1 mt-5 text-center text-white">{{ $this->experiment['name'] }}</h1>
    <h4 class="mb-4 text-center text-muted">{{ $this->experiment['id'] }} ({{ $this->experiment['hash'] }})</h4>
    <div class="mt-2 mb-4">

        @if($this->experiment['type'] == "guild" && !empty($this->filters))
        <div class="row mb-2">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="card text-white bg-dark border-0">
                    <div class="card-header">
                        <h1 class="fw-bold">{{ __('Filters') }} <i class="far fa-question-circle text-muted align-middle" style="font-size: 0.5em !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('The filters apply to all treatments and must be fulfilled') }}"></i></h1>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @foreach($this->filters as $filter)
                                <span class="badge bg-primary my-1" style="font-size: 1rem;">{{ $filter }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row mb-5">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="card text-white bg-dark border-0">
                    <div class="card-header">
                        <h1 class="fw-bold">{{ __('Treatments') }} <i class="far fa-question-circle text-muted align-middle" style="font-size: 0.5em !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Different versions of the experiment that can be activated') }}"></i></h1>
                    </div>
                    <div class="card-body">
                        @foreach($this->buckets as $bucket)
                            <h5 class="mb-3 text-primary">{{ $bucket['name'] }} <small class="text-white-50">{!! ($bucket['description'] == "" ? "<i>No description</i>" : $bucket['description']) !!}</small></h5>
                            @if(($this->experiment['type'] == "guild" && $bucket['id'] == 0 && array_key_exists("BUCKET {$bucket['id']}", $this->groups) && $this->groups["BUCKET {$bucket['id']}"]['count'] > 0) || (!empty($this->groups["BUCKET {$bucket['id']}"]['groups']) && array_key_exists("BUCKET {$bucket['id']}", $this->groups)))
                                <div class="mb-3">
                                    <b>Groups</b> <i class="far fa-question-circle text-muted small align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('The percentage of guilds that have this treatment') }}"></i><br>
                                    @foreach($this->groups["BUCKET {$bucket['id']}"]['groups'] as $group)
                                        <span class="badge bg-primary">{{ ($group['end'] - $group['start']) / (10000)*100 }}% ({{ $group['start'] }} - {{ $group['end'] }})</span>
                                    @endforeach
                                    @if($bucket['id'] == 0 && $this->groups["BUCKET {$bucket['id']}"]['count'] > 0)
                                        <span class="badge bg-primary">{{ $this->groups["BUCKET {$bucket['id']}"]['count'] / (10000)*100 }}%</span>
                                    @endif
                                    <br>
                                </div>
                            @endif
                            @if(!empty($this->overrides) && array_key_exists($bucket['id'], $this->overrides))
                                <div>
                                    <b>Overrides ({{ sizeof($this->overrides[$bucket['id']]) }})</b> <i class="far fa-question-circle text-muted small align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Server that have the treatment in any case') }}"></i><br>
                                    @foreach($this->overrides[$bucket['id']] as $override)
                                        @if($loop->index == 15)
                                            <span class="badge bg-primary" style="cursor: pointer;" onclick="document.getElementById('allOverrides{{ $bucket['id'] }}').style.display = '';this.style.display = 'none';">{{ __('Show all') }}</span>
                                            <span id="allOverrides{{ $bucket['id'] }}" style="display: none">
                                        @endif
                                        <a href="{{ route('guildlookup', ['snowflake' => $override]) }}" class="text-decoration-none" rel="nofollow">
                                            <span class="badge bg-body">{{ $override }}</span>
                                        </a>
                                        @if($loop->last)
                                            </span>
                                        @endif
                                    @endforeach
                                    <br>
                                </div>
                            @endif
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                        @if(!empty($this->experiment['rollout']))
                            <hr>
                            <div wire:ignore id="treatmentsChart" style="width: 100%; height: 400px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($this->experiment['type'] == "guild" && !empty($this->experiment['rollout']))
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="card text-white bg-dark border-0">
                    <div class="card-header">
                        <h1 class="fw-bold" id="guilds">{{ __('Guilds') }} <i class="far fa-question-circle text-muted align-middle" style="font-size: 0.5em !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('List of all guilds you are on, which have this experiment') }}"></i></h1>
                    </div>
                    <div class="card-body">
                        @guest
                            <div class="text-center">
                                <h4>{{ __('To get experiment infos about your guilds you need to log in with Discord.') }}</h4>
                                <h5>{!! __('This website is open source on :github.', ['github' => '<a href="' . env('GITHUB_URL') . '" target="_blank">GitHub</a>']) !!}</h5>
                                <a role="button" class="btn btn-info mt-3" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                            </div>
                        @endguest
                        @auth
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <select wire:model="treatment" class="form-select">
                                        @foreach($this->buckets as $bucket)
                                            <option value="{{ $bucket['name'] }}">{{ $bucket['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-md-0">
                                    <select wire:model="order" class="form-select">
                                        <option value="name-asc" selected>{{ __('Name Ascending') }}</option>
                                        <option value="name-desc">{{ __('Name Descending') }}</option>
                                        <option value="id-asc">{{ __('Created Ascending') }}</option>
                                        <option value="id-desc">{{ __('Created Descending') }}</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            @if(empty($this->guilds))
                                <div>
                                    {{ __('No Guild found.') }}
                                </div>
                            @endif
                            @foreach($this->guilds as $guildTreatments)
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

                                            @if($guild['owner'])
                                                <img src="{{ asset('images/discord/icons/server/owner.png') }}" class="discord-badge" alt="owner badge" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('You own') }}">
                                            @elseif((($guild['permissions'] & (1 << 3)) == (1 << 3)))
                                                <img src="{{ asset('images/discord/icons/server/administrator.png') }}" class="discord-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('You administrate') }}">
                                            @elseif((
                                                (($guild['permissions'] & (1 << 1)) == (1 << 1)) || // KICK_MEMBERS
                                                (($guild['permissions'] & (1 << 2)) == (1 << 2)) || // BAN_MEMBERS
                                                (($guild['permissions'] & (1 << 4)) == (1 << 4)) || // MANAGE_CHANNELS
                                                (($guild['permissions'] & (1 << 5)) == (1 << 5)) || // MANAGE_GUILD
                                                (($guild['permissions'] & (1 << 13)) == (1 << 13)) || // MANAGE_MESSAGES
                                                (($guild['permissions'] & (1 << 27)) == (1 << 27)) || // MANAGE_NICKNAMES
                                                (($guild['permissions'] & (1 << 28)) == (1 << 28)) || // MANAGE_ROLES
                                                (($guild['permissions'] & (1 << 29)) == (1 << 29)) || // MANAGE_WEBHOOKS
                                                (($guild['permissions'] & (1 << 34)) == (1 << 34)) // MANAGE_THREADS
                                            ))
                                                <img src="{{ asset('images/discord/icons/server/moderator.png') }}" class="discord-badge" alt="moderator badge" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('You moderate') }}">
                                            @endif
                                            @if(in_array('VERIFIED', $guild['features']))
                                                <img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="verified badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Discord Verified">
                                            @endif
                                            @if(in_array('PARTNERED', $guild['features']))
                                                <img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="partner badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Discord Partner">
                                            @endif
                                        </div>
                                        <div class="mt-n1">
                                            <small class="text-muted">
                                                {{ $guild['id'] }}
                                                &bull;
                                                {{ date('Y-m-d', (($guild['id'] >> 22) + 1420070400000) / 1000) }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 text-center text-md-end">
                                        <a role="button" href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}" rel="nofollow" class="btn btn-sm btn-outline-primary mt-2 mt-xl-0">{{ __('Guild Info') }}</a>
                                        <button wire:click="$emitTo('guild-features-modal', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-success mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalFeatures">{{ __('Features') }}</button>
                                        <button wire:click="$emitTo('guild-permissions-modal', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')" class="btn btn-sm btn-outline-danger mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalPermissions">{{ __('Permissions') }}</button>
                                        <button wire:click="$emitTo('guild-experiments-modal', 'update', '{{ $guild['id'] }}', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-warning mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalExperiments">{{ __('Experiments') }}</button>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($this->experiment['type'] == "guild" && !empty($this->experiment['rollout']))
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Treatment', 'Count'],
                    @foreach($this->buckets as $bucket)
                        @if(!empty($this->groups) && array_key_exists("BUCKET {$bucket['id']}", $this->groups))
                            ['{{ $bucket['name'] }}', {{ $this->groups["BUCKET {$bucket['id']}"]['count'] }}],
                        @endif
                    @endforeach
                ]);

                var options = {
                    is3D: true,
                    legend: 'none',
                    pieSliceText: 'label',
                    backgroundColor: { fill:'transparent' }
                };

                var chart = new google.visualization.PieChart(document.getElementById('treatmentsChart'));
                chart.draw(data, options);
            }
        </script>
        @endif

    </div>
</div>
