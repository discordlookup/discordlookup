<?php

namespace App\Http\Livewire\Modal;

use lastguest\Murmur;
use Livewire\Component;

class GuildExperiments extends Component
{
    public $guildId = '';
    public $guildName = '';
    public $features = [];
    public $experiments = [];

    protected $listeners = ['update'];

    public function update($guildId, $guildName, $features)
    {
        $this->reset();

        $this->guildId = $guildId;
        $this->guildName = urldecode($guildName);
        $this->features = json_decode($features);

        $experimentsJson = getExperiments();

        $allExperiments = [];
        foreach ($experimentsJson as $entry)
        {
            if($entry['type'] == 'guild' && !empty($entry['rollout']))
                $allExperiments[] = $entry;
        }

        foreach ($allExperiments as $experiment)
        {
            $murmurhash = Murmur::hash3_int($experiment['id'] . ':' . $this->guildId);
            $murmurhash = $murmurhash % 10000;

            $treatments = [];
            $filters = [];
            foreach ($experiment['rollout'][3] as $population)
            {
                $filterPassed = true;

                foreach ($population[1] as $filter)
                {
                    switch ($filter[0])
                    {
                        case 1604612045: // Feature
                            foreach ($filter[1][0][1] as $popfilter)
                            {
                                if(!in_array($popfilter, $this->features))
                                    $filterPassed = false;
                            }
                            break;

                        case 2918402255: // MemberCount
                            $filters[] = "(Only if server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more")) . ")";
                            break;

                        case 2404720969: // ID
                            if(!(
                                $this->guildId >= ($filter[1][0][1] ?? 0) &&
                                $this->guildId <= $filter[1][1][1]
                            )) {
                                $filterPassed = false;
                            }
                            break;
                    }
                }

                if($filterPassed) {
                    $treatment = 'None';
                    foreach ($population[0] as $bucket)
                    {
                        foreach ($experiment['buckets'] as $treatmentsList)
                        {
                            if($treatmentsList['id'] == $bucket[0])
                            {
                                $treatment = $treatmentsList['name'] . ': ' . $treatmentsList['description'];
                                break;
                            }
                        }
                        foreach ($bucket[1] as $rollout) {
                            if(
                                $murmurhash >= $rollout['s'] &&
                                $murmurhash <= $rollout['e']
                            ) {
                                if(!str_starts_with($treatment, 'None:')) {
                                    $treatments[] = $treatment;
                                }
                            }
                        }
                    }
                }
            }

            $isOverride = false;
            foreach ($experiment['rollout'][4] as $overrides)
            {
                $treatment = "None";
                foreach ($experiment['buckets'] as $treatmentsList)
                {
                    if($treatmentsList['id'] == $overrides['b'])
                    {
                        $treatment = $treatmentsList['name'] . ': ' . $treatmentsList['description'];
                        break;
                    }
                }

                foreach ($overrides['k'] as $guildId)
                {
                    if($guildId == $this->guildId) {
                        if(!str_starts_with($treatment, 'None:'))
                        {
                            if(!in_array($treatment, $treatments))
                                $treatments[] = $treatment;

                            $isOverride = true;
                        }
                    }
                }
            }

            if(!empty($treatments))
            {
                $this->experiments[] = [
                    'title' => $experiment['name'],
                    'treatments' => $treatments,
                    'override' => $isOverride,
                    'filters' => $filters,
                ];
            }
        }
    }

    public function render()
    {
        return view('modal.guild-experiments');
    }
}
