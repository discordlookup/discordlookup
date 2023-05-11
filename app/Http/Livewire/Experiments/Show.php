<?php

namespace App\Http\Livewire\Experiments;

use lastguest\Murmur;
use Livewire\Component;

class Show extends Component
{
    public $experimentId = '';
    public $experiment = [];
    public $buckets = [];
    public $rollouts = [];
    public $overrides = [];
    public $guilds = [];

    public $treatment = -1;
    public $sorting = 'title-asc';

    public function loadExperiments()
    {
        $experimentHash = Murmur::hash3_int($this->experimentId);
        $this->experiment = getExperiments($experimentHash);


        if(!empty($this->experiment['buckets']))
        {
            $this->buckets["BUCKET -1"] = [
                'id' => -1,
                'name' => 'None',
                'description' => '',
            ];

            foreach ($this->experiment['buckets'] as $bucketList)
            {
                $this->buckets["BUCKET {$bucketList['id']}"] = [
                    'id' => $bucketList['id'],
                    'name' => $bucketList['name'],
                    'description' => $bucketList['description'],
                ];
            }
        }

        if(!empty($this->experiment['rollout']))
        {
            foreach ($this->experiment['rollout'][3] as $population)
            {
                $globalCount = 0;
                $buckets = [];
                foreach ($population[0] as $bucket)
                {
                    $count = 0;
                    $groups = [];
                    foreach ($bucket[1] as $rollout)
                    {
                        $count += $rollout['e'] - $rollout['s'];
                        $groups[] = [
                            'start' => $rollout['s'],
                            'end' => $rollout['e'],
                        ];
                    }

                    $buckets[] = [
                        'id' => $bucket[0],
                        'count' => $count,
                        'groups' => $groups,
                    ];

                    $globalCount += $count;
                }

                $buckets[] = [
                    'id' => 0,
                    'count' => (10000 - $globalCount),
                    'groups' => [],
                ];

                $filters = [];
                foreach ($population[1] as $filter)
                {
                    switch ($filter[0])
                    {
                        case 1604612045: // Feature
                            $allFeatures = [];
                            foreach ($filter[1][0][1] as $popfilter) {
                                $allFeatures[] = $popfilter;
                            }
                            $filters[] = "Server must have feature " . implode(', ', $allFeatures);
                            break;

                        case 2918402255: // MemberCount
                            $filters[] = "Server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more"));
                            break;

                        case 2404720969: // ID Range
                            $filters[] = "Server ID is between " . ($filter[1][0][1] ?? 0) . " and " . $filter[1][1][1];
                            break;

                        case 3013771838: // ID
                            $allIds = [];
                            foreach ($filter[1][0][1] as $popfilter) {
                                $allIds[] = $popfilter;
                            }
                            $filters[] = "Server ID is " . implode(', ', $allIds);
                            break;

                        case 4148745523: // HubType
                            $hubTypes = ['Default', 'High School', 'College'];
                            $allHubTypes = [];
                            foreach ($filter[1][0][1] as $popfilter) {
                                $allHubTypes[] = $hubTypes[$popfilter];
                            }
                            $filters[] = "Server hub type is " . implode(', ', $allHubTypes);
                            break;

                        case 2294888943: // RangeByHash
                            $filters[] = ($filter[1][1][1] / 100) . "% of servers (HashKey " . $filter[1][0][1] . ", target " . $filter[1][1][1] . ")";
                            break;
                    }
                }

                $this->rollouts[] = [
                    'filters' => $filters,
                    'buckets' => $buckets,
                ];
            }

            foreach ($this->experiment['rollout'][4] as $overrides)
            {
                $this->overrides[$overrides['b']] = $overrides['k'];
            }
        }
    }

    public function loadGuilds()
    {
        $this->guilds = [];
        $guildsJson = auth()->user()->guildList;

        if($guildsJson != null && is_array($guildsJson) && $this->experiment['rollout'])
        {
            foreach ($guildsJson as $guild)
            {
                $murmurhash = Murmur::hash3_int($this->experimentId . ':' . $guild['id']);
                $murmurhash = $murmurhash % 10000;

                $guildFilters = [];
                $guildBucket = -1;
                foreach ($this->experiment['rollout'][3] as $population)
                {
                    $filterPassed = true;
                    $filters = [];
                    foreach ($population[1] as $filter)
                    {
                        switch ($filter[0])
                        {
                            case 1604612045: // Feature
                                foreach ($filter[1][0][1] as $popfilter)
                                {
                                    if(!in_array($popfilter, $guild['features']))
                                        $filterPassed = false;
                                }
                                break;

                            case 2918402255: // MemberCount
                                $filters[] = "(Only if server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more")) . ")";
                                break;

                            case 2404720969: // ID Range
                                if(!(
                                    $guild['id'] >= ($filter[1][0][1] ?? 0) &&
                                    $guild['id'] <= $filter[1][1][1]
                                )) {
                                    $filterPassed = false;
                                }
                                break;

                            case 3013771838: // ID
                                if(!in_array($guild['id'], $filter[1][0][1]))
                                    $filterPassed = false;
                                break;

                            case 4148745523: // HubType
                                // TODO: Check HubType
                                $hubTypes = ['Default', 'High School', 'College'];
                                $allHubTypes = [];
                                foreach ($filter[1][0][1] as $popfilter) {
                                    $allHubTypes[] = $hubTypes[$popfilter];
                                }
                                $filters[] = "(Only if server hub type is " . implode(', ', $allHubTypes) . ")";
                                break;

                            case 2294888943: // RangeByHash
                                // TODO: Check RangeByHash
                                if($filter[1][1][1] != 10000)
                                    $filters[] = "(Only if HashKey " . $filter[1][0][1] . ", target " . $filter[1][1][1] . ")";
                                break;
                        }
                    }

                    if($filterPassed)
                    {
                        foreach ($population[0] as $bucket)
                        {
                            foreach ($bucket[1] as $rollout)
                            {
                                if(
                                    $murmurhash >= $rollout['s'] &&
                                    $murmurhash <= $rollout['e']
                                ) {
                                    if($bucket[0] != -1)
                                    {
                                        $guildBucket = $bucket[0];
                                        $guildFilters = $filters;
                                    }
                                }
                            }
                        }
                    }
                }

                $isOverride = false;
                foreach ($this->experiment['rollout'][4] as $overrides)
                {
                    foreach ($overrides['k'] as $guildId)
                    {
                        if($guild['id'] == $guildId)
                        {
                            $guildBucket = $overrides['b'];
                            $isOverride = true;
                        }
                    }
                }

                if($this->treatment == $guildBucket)
                {
                    $this->guilds[] = [
                        'guild' => $guild,
                        'bucket' => $guildBucket,
                        'filters' => $guildFilters,
                        'override' => $isOverride,
                    ];
                }
            }
        }
    }

    public function sorting()
    {
        $sortKey = explode('-', $this->sorting);
        if($sortKey[1] == 'desc') {
            usort($this->guilds, function($a, $b) use ($sortKey) {
                return $b['guild'][$sortKey[0]] <=> $a['guild'][$sortKey[0]];
            });
        }else{
            usort($this->guilds, function($a, $b) use ($sortKey) {
                return $a['guild'][$sortKey[0]] <=> $b['guild'][$sortKey[0]];
            });
        }
    }

    public function mount()
    {
        $this->loadExperiments();
    }

    public function render()
    {
        if(auth()->check())
        {
            $this->loadGuilds();
            $this->sorting();
        }

        return view('experiments.show')->extends('layouts.app');
    }
}
