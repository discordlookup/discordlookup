@section('title', "{$experiment['name']} Experiment")
@section('description', "Information and rollout status about the {$experiment['name']} Experiment.")
@section('keywords', "client, guild, experiments, discord experiments, rollout, rollouts, treatments, groups, overrides, population, {$experiment['id']}")

<div id="experiment">
    <h1 class="mb-1 mt-5 text-center text-white">{{ $experiment['name'] }}</h1>
    <h4 class="mb-4 text-center text-muted">{{ $experiment['id'] }} ({{ $experiment['hash'] }})</h4>
    <div class="mt-2 mb-4">

        @if($experiment['type'] == "guild" && !empty($filters))
        <div class="row mb-2">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="card text-white bg-dark border-0">
                    <div class="card-header">
                        <h1 class="fw-bold">{{ __('Filters') }} <i class="far fa-question-circle text-muted align-middle" style="font-size: 0.5em !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('The filters apply to all treatments and must be fulfilled') }}"></i></h1>
                    </div>
                    <div class="card-body">
                        @foreach($filters as $filter)
                            <span class="badge bg-primary" style="font-size: 1rem;">{{ $filter }}</span>
                        @endforeach
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

                            @if(($experiment['type'] == "guild" && $bucket['id'] == 0 && array_key_exists($bucket['id'], $this->groups) && $this->groups[$bucket['id']]['count'] > 0) || (!empty($this->groups[$bucket['id']]['groups']) && array_key_exists($bucket['id'], $this->groups)))
                                <div class="mb-3">
                                    <b>Groups</b> <i class="far fa-question-circle text-muted small align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('The percentage of guilds that have this treatment') }}"></i><br>
                                    @foreach($this->groups[$bucket['id']]['groups'] as $group)
                                        <span class="badge bg-primary">{{ ($group['end'] - $group['start']) / (10000)*100 }}% ({{ $group['start'] }} - {{ $group['end'] }})</span>
                                    @endforeach
                                    @if($bucket['id'] == 0 && $this->groups[$bucket['id']]['count'] > 0)
                                        <span class="badge bg-primary">{{ $this->groups[$bucket['id']]['count'] / (10000)*100 }}%</span>
                                    @endif
                                    <br>
                                </div>
                            @endif

                            @if(!empty($this->overrides) && array_key_exists($bucket['id'], $this->overrides))
                                <div>
                                    <b>Overrides ({{ sizeof($this->overrides[$bucket['id']]) }})</b> <i class="far fa-question-circle text-muted small align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Server that have the treatment in any case') }}"></i><br>
                                    @foreach($this->overrides[$bucket['id']] as $override)
                                        <a href="{{ route('guildlookup', ['snowflake' => $override]) }}" class="text-decoration-none" rel="nofollow">
                                            <span class="badge bg-body">{{ $override }}</span>
                                        </a>
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
                            <div id="treatmentsChart" style="width: 100%; height: 400px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($experiment['type'] == "guild")
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
                            <div class="text-center">
                                <h2 class="fw-bold">Coming soon!</h2>
                                <h3>A list of all your guilds that have this experiment will be available soon.</h3>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($experiment['type'] == "guild" && !empty($this->experiment['rollout']))
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Treatment', 'Count'],
                    @foreach($this->buckets as $bucket)
                        @if(!empty($this->groups) && array_key_exists($bucket['id'], $this->groups))
                            ['{{ $bucket['name'] }}', {{ $this->groups[$bucket['id']]['count'] }}],
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
