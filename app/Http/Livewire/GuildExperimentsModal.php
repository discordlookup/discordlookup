<?php

namespace App\Http\Livewire;

use lastguest\Murmur;
use Livewire\Component;

class GuildExperimentsModal extends Component
{

    public $json = "[]";
    public $guildId = "";
    public $guildName = "";
    public $features = [];
    public $experiments = [];

    protected $listeners = ['parseJson'];

    public function parseJson($json, $guildId, $guildName, $features) {

        $this->reset();

        $this->json = $json;
        $this->guildId = $guildId;
        $this->guildName = urldecode($guildName);
        $this->features = json_decode($features);

        $allExperiments = [];
        foreach ($this->json as $entry) {
            array_push($allExperiments, $entry);
        }

        foreach ($allExperiments as $experiment) {
            $murmurhash = Murmur::hash3_int($experiment['data']['id'] . ":" . $this->guildId);
            $murmurhash = $murmurhash % 10000;

            $treatments = [];
            $filters = [];
            foreach ($experiment['rollout'][3] as $population) {

                $filterPassed = true;

                foreach ($population[1] as $filter) {
                    switch ($filter[0]) {

                        case 1604612045: // Feature
                            foreach ($filter[1][0][1] as $popfilter) {
                                if(!in_array($popfilter, $this->features)) {
                                    $filterPassed = false;
                                }
                            }
                            break;

                        case 2918402255: // MemberCount
                            array_push($filters, "<span class='text-muted'>(Only if server member count is " . ($filter[1][1][1] ? ("in range " . ($filter[1][0][1] ?? 0) . "-" . $filter[1][1][1]) : ($filter[1][0][1] . " or more")) . ")</span>");
                            break;

                        case 2404720969: // ID
                            if(
                                !(
                                    $this->guildId >= ($filter[1][0][1] ?? 0) &&
                                    $this->guildId <= $filter[1][1][1]
                                )
                            ) {
                                $filterPassed = false;
                            }
                            break;
                    }
                }

                if($filterPassed) {

                    $treatment = "None";

                    foreach ($population[0] as $bucket) {
                        foreach ($experiment['data']['description'] as $treatmentsList) {
                            if(str_starts_with($treatmentsList, "Treatment " . $bucket[0] . ":")) {
                                $treatment = $treatmentsList;
                                break;
                            }
                        }
                        foreach ($bucket[1] as $rollout) {
                            if(
                                $murmurhash >= $rollout['s'] &&
                                $murmurhash <= $rollout['e']
                            ) {
                                if($treatment != "None") {
                                    array_push($treatments, $treatment);
                                }
                            }
                        }
                    }
                }
            }

            $isOverride = false;
            foreach ($experiment['rollout'][4] as $overrides) {
                $treatment = "None";
                foreach ($experiment['data']['description'] as $treatmentsList) {
                    if(str_starts_with($treatmentsList, "Treatment " . $overrides['b'] . ":")) {
                        $treatment = $treatmentsList;
                        break;
                    }
                }
                foreach ($overrides['k'] as $guildId) {
                    if($guildId == $this->guildId) {
                        if($treatment != "None") {
                            if(!in_array($treatment, $treatments)) {
                                array_push($treatments, $treatment);
                            }
                            $isOverride = true;
                        }
                    }
                }
            }

            if(sizeof($treatments) > 0) {
                array_push($this->experiments, [
                    'title' => $experiment['data']['title'],
                    'treatments' => $treatments,
                    'filters' => $filters,
                    'override' => $isOverride,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.guild-experiments-modal');
    }
}
