<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
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

    public function loadExperiments() {

        if(Cache::has('experimentsJson')) {
            $this->experimentsJson = Cache::get('experimentsJson');
        }else{
            $response = Http::get('https://experiments.fbrettnich.workers.dev/');
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

        foreach ($experiment['buckets'] as $bucketList) {
            array_push($this->buckets, [
                'id' => $bucketList['id'],
                'name' => $bucketList['name'],
                'description' => $bucketList['description'],
            ]);
        }

        if(!empty($this->experiment['rollout'])) {
            foreach ($this->experiment['rollout'][3] as $population) {
                $globalCount = 0;
                foreach ($population[0] as $bucket) {
                    $count = 0;
                    $groups = [];
                    foreach ($bucket[1] as $rollout) {
                        $count += $rollout['e'] - $rollout['s'];
                        array_push($groups, [
                            'start' => $rollout['s'],
                            'end' => $rollout['e'],
                        ]);
                    }
                    $this->groups[$bucket[0]] = [
                        'count' => $count,
                        'groups' => $groups,
                    ];
                    $globalCount += $count;
                }
                $this->groups[0] = [
                    'count' => (10000 - $globalCount),
                    'groups' => [],
                ];

                foreach ($population[1] as $filter) {
                    switch ($filter[0]) {
                        case 1604612045: // Feature
                            foreach ($filter[1][0][1] as $popfilter) {
                                array_push($this->filters, "Server must have feature " . $popfilter);
                            }
                            break;
                        case 2918402255: // MemberCount
                            array_push($this->filters, "Server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more")));
                            break;
                        case 2404720969: // ID
                            array_push($this->filters, "Server ID is between " . ($filter[1][0][1] ?? 0) . " and " . $filter[1][1][1]);
                            break;
                    }
                }
            }

            foreach ($this->experiment['rollout'][4] as $overrides) {
                $this->overrides[$overrides['b']] = $overrides['k'];
            }
        }
    }

    public function mount() {
        $this->loadExperiments();
    }

    public function render()
    {
        return view('livewire.experiment');
    }
}
