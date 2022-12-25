<?php

namespace App\Http\Livewire\Modal;

use lastguest\Murmur;
use Livewire\Component;

class GuildExperiments extends Component
{
    public $guildId = '';
    public $guildName = '';
    public $guildFeatures = [];
    public $experiments = [];

    protected $listeners = ['update'];

    public function update($guildId, $guildName, $features)
    {
        $this->reset();

        $this->guildId = $guildId;
        $this->guildName = urldecode($guildName);
        $this->guildFeatures = json_decode($features);

        $experimentsJson = getExperiments();

        $allExperiments = [];
        foreach ($experimentsJson as $entry)
        {
            if($entry['type'] == 'guild' && $entry['rollout'])
                $allExperiments[] = $entry;
        }

        foreach ($allExperiments as $experiment)
        {
            $buckets = [];
            if($experiment['buckets'])
            {
                foreach ($experiment['buckets'] as $bucketList)
                {
                    $buckets["BUCKET {$bucketList['id']}"] = [
                        'id' => $bucketList['id'],
                        'name' => $bucketList['name'],
                        'description' => $bucketList['description'],
                    ];
                }
            }

            $murmurhash = Murmur::hash3_int($experiment['id'] . ':' . $this->guildId);
            $murmurhash = $murmurhash % 10000;

            $guildFilters = [];
            $guildBucket = -1;
            foreach ($experiment['rollout'][3] as $population)
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
                                if(!in_array($popfilter, $this->guildFeatures))
                                    $filterPassed = false;
                            }
                            break;

                        case 2918402255: // MemberCount
                            $filters[] = "(Only if server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more")) . ")";
                            break;

                        case 2404720969: // ID Range
                            if(!(
                                $this->guildId >= ($filter[1][0][1] ?? 0) &&
                                $this->guildId <= $filter[1][1][1]
                            )) {
                                $filterPassed = false;
                            }
                            break;

                        case 3013771838: // ID
                            if(!in_array($this->guildId, $filter[1][0][1]))
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
            foreach ($experiment['rollout'][4] as $overrides)
            {
                foreach ($overrides['k'] as $guildId)
                {
                    if($this->guildId == $guildId)
                    {
                        $guildBucket = $overrides['b'];
                        $isOverride = true;
                    }
                }
            }

            if($guildBucket != -1)
            {
                $bucket = $buckets["BUCKET {$guildBucket}"];
                $this->experiments[] = [
                    'id' => $experiment['id'],
                    'title' => $experiment['name'],
                    'treatment' => "{$bucket['name']}: {$bucket['description']}",
                    'filters' => $guildFilters,
                    'override' => $isOverride,
                ];
            }
        }
    }

    public function render()
    {
        return view('modal.guild-experiments');
    }
}
