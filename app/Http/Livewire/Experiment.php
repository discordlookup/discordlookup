<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use lastguest\Murmur;
use Livewire\Component;

class Experiment extends Component
{

    public $experimentId = "";
    public $experimentsJson = [];
    public $experiment = [];
    public $buckets = [];
    public $filters = [];
    public $groups = [];
    public $overrides = [];
    public $guilds = [];

    public $treatment = "None";
    public $order = "name-asc";

    public function loadExperiments() {

        if(Cache::has('experimentsJson')) {
            $this->experimentsJson = Cache::get('experimentsJson');
        }else{
            $response = Http::get(env('EXPERIMENTS_WORKER'));
            if($response->ok()) {
                $this->experimentsJson = $response->json();
                Cache::put('experimentsJson', $this->experimentsJson, 900); // 15 minutes
            }
        }

        foreach ($this->experimentsJson as $experiment) {
            if($experiment['id'] == $this->experimentId) {
                $this->experiment = $experiment;
                break;
            }
        }

        foreach ($this->experiment['buckets'] as $bucketList) {
            $this->buckets[] = [
                'id' => $bucketList['id'],
                'name' => $bucketList['name'],
                'description' => $bucketList['description'],
            ];
        }

        if(!empty($this->experiment['rollout'])) {
            foreach ($this->experiment['rollout'][3] as $population) {
                $globalCount = 0;
                foreach ($population[0] as $bucket) {
                    $count = 0;
                    $groups = [];
                    foreach ($bucket[1] as $rollout) {
                        $count += $rollout['e'] - $rollout['s'];
                        $groups[] = [
                            'start' => $rollout['s'],
                            'end' => $rollout['e'],
                        ];
                    }
                    $this->groups["BUCKET {$bucket[0]}"] = [
                        'count' => $count,
                        'groups' => $groups,
                    ];
                    $globalCount += $count;
                }
                $this->groups["BUCKET 0"] = [
                    'count' => (10000 - $globalCount),
                    'groups' => [],
                ];

                foreach ($population[1] as $filter) {
                    switch ($filter[0]) {
                        case 1604612045: // Feature
                            foreach ($filter[1][0][1] as $popfilter) {
                                $this->filters[] = "Server must have feature " . $popfilter;
                            }
                            break;
                        case 2918402255: // MemberCount
                            $this->filters[] = "Server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more"));
                            break;
                        case 2404720969: // ID
                            $this->filters[] = "Server ID is between " . ($filter[1][0][1] ?? 0) . " and " . $filter[1][1][1];
                            break;
                    }
                }
            }

            foreach ($this->experiment['rollout'][4] as $overrides) {
                $this->overrides[$overrides['b']] = $overrides['k'];
            }
        }
    }

    public function loadGuilds() {

        $this->guilds = [];
        $guildsJson = session('guildsJson');

        if($guildsJson != null) {
            foreach ($guildsJson as $guild) {
                $murmurhash = Murmur::hash3_int($this->experimentId . ':' . $guild['id']);
                $murmurhash = $murmurhash % 10000;

                $treatments = [];
                $filters = [];
                foreach ($this->experiment['rollout'][3] as $population) {

                    $filterPassed = true;

                    foreach ($population[1] as $filter) {
                        switch ($filter[0]) {
                            case 1604612045: // Feature
                                foreach ($filter[1][0][1] as $popfilter) {
                                    if(!in_array($popfilter, $guild['features'])) {
                                        $filterPassed = false;
                                    }
                                }
                                break;
                            case 2918402255: // MemberCount
                                $filters[] = "(Only if server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more")) . ")";
                                break;
                            case 2404720969: // ID
                                if(!(
                                    $guild['id'] >= ($filter[1][0][1] ?? 0) &&
                                    $guild['id'] <= $filter[1][1][1]
                                )) {
                                    $filterPassed = false;
                                }
                                break;
                        }
                    }

                    if($filterPassed) {
                        $treatment = "None";
                        foreach ($population[0] as $bucket) {
                            foreach ($this->experiment['buckets'] as $treatmentsList) {
                                if($treatmentsList['id'] == $bucket[0]) {
                                    $treatment = $treatmentsList['name'];
                                    break;
                                }
                            }
                            foreach ($bucket[1] as $rollout) {
                                if(
                                    $murmurhash >= $rollout['s'] &&
                                    $murmurhash <= $rollout['e']
                                ) {
                                    if(!str_starts_with($treatment, "None:")) {
                                        $treatments[] = $treatment;
                                    }
                                }
                            }
                        }
                    }
                }

                $isOverride = false;
                foreach ($this->experiment['rollout'][4] as $overrides) {
                    $treatment = "None";
                    foreach ($this->experiment['buckets'] as $treatmentsList) {
                        if($treatmentsList['id'] == $overrides['b']) {
                            $treatment = $treatmentsList['name'];
                            break;
                        }
                    }
                    foreach ($overrides['k'] as $guildId) {
                        if($guild['id'] == $guildId) {
                            if(!str_starts_with($treatment, "None:")) {
                                if(!in_array($treatment, $treatments)) {
                                    $treatments[] = $treatment;
                                }
                                $isOverride = true;
                            }
                        }
                    }
                }

                if(!empty($treatments)) {
                    if(sizeof($treatments) > 1) {
                        for ($i = 0; $i < sizeof($treatments); $i++) {
                            if ($treatments[$i] == "None") {
                                unset($treatments[$i]);
                            }
                        }
                    }
                    if(in_array($this->treatment, $treatments)) {
                        $this->guilds[] = [
                            'treatments' => $treatments,
                            'override' => $isOverride,
                            'filters' => $filters,
                            'guild' => $guild,
                        ];
                    }
                }
            }
        }
    }

    public function order() {
        $sortKey = explode('-', $this->order);
        if($sortKey[1] == "desc") {
            usort($this->guilds, function($a, $b) use ($sortKey) {
                return $b['guild'][$sortKey[0]] <=> $a['guild'][$sortKey[0]];
            });
        }else{
            usort($this->guilds, function($a, $b) use ($sortKey) {
                return $a['guild'][$sortKey[0]] <=> $b['guild'][$sortKey[0]];
            });
        }
    }

    public function mount() {
        $this->loadExperiments();
    }

    public function render()
    {
        if(auth()->check()) {
            $this->loadGuilds();
            $this->order();
        }
        return view('livewire.experiment');
    }
}
