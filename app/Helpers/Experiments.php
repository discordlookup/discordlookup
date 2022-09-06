<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * @return array|mixed
 */
function getExperiments()
{
    if(!Cache::has('experimentsJson'))
        loadExperiments();

    return Cache::get('experimentsJson');
}


function loadExperiments()
{
    $response = Http::timeout(10)->get(env('EXPERIMENTS_WORKER'));
    if($response->ok()) {
        $experimentsJson = $response->json();
        Cache::put('experimentsJson', $experimentsJson);
    }
}

function watchExperiments()
{
    $experimentsNew = [];
    $experimentsUpdated = [];
    $experimentsJson = getExperiments();
    $experimentsList = \App\Models\ExperimentsWatcher::all();

    foreach ($experimentsJson as $experiment)
    {
        $experimentItem = $experimentsList->where('experiment_id', '=', $experiment['id'])->first();
        $updateExperimentItem = false;

        if($experimentItem == null)
        {
            $experimentItem = new \App\Models\ExperimentsWatcher();
            $experimentsNew[] = $experiment;
            $updateExperimentItem = true;
        }
        else if($experimentItem->experiment_updated != round($experiment['updated']))
        {
            $experimentsUpdated[] = $experiment;
            $updateExperimentItem = true;

            echo $experimentItem->experiment_updated . ' | ' . round($experiment['updated']) . '
            ';
        }

        if($updateExperimentItem)
        {
            $experimentItem->experiment_id = $experiment['id'];
            $experimentItem->experiment_hash = $experiment['hash'];
            $experimentItem->experiment_name = $experiment['name'];
            $experimentItem->experiment_created = round($experiment['created']);
            $experimentItem->experiment_updated = round($experiment['updated']);
            $experimentItem->experiment_type = $experiment['type'];
            $experimentItem->save();
        }
    }

    postExperiments($experimentsNew, $experimentsUpdated);
}

function postExperiments($experimentsNew, $experimentsUpdated)
{
    $i = 1;
    $embed = [
        'content' => '<@&1016667060580909066>',
        'embeds' => [],
    ];

    foreach ($experimentsNew as $experiment)
    {
        if($i > 10) break;

        if (($key = array_search($experiment, $experimentsNew)) !== false)
            unset($experimentsNew[$key]);

        $embed['embeds'][] = [
            'title' => $experiment['name'],
            'url' => 'https://discordlookup.com/experiment/' . $experiment['id'],
            'color' => 5763719,
            'author' => [
                'name' => 'New Experiment',
            ],
            'fields' => [
                [
                    'name' => 'Name',
                    'value' => $experiment['name'],
                    'inline' => true,
                ],
                [
                    'name' => 'ID',
                    'value' => $experiment['id'],
                    'inline' => true,
                ],
                [
                    'name' => 'Hash',
                    'value' => $experiment['hash'],
                    'inline' => true,
                ],
                [
                    'name' => 'Type',
                    'value' => ucwords($experiment['type']),
                    'inline' => true,
                ],
                [
                    'name' => 'Created',
                    'value' => '<t:' . round($experiment['created']) . ':f> (<t:' . round($experiment['created']) . ':R>)',
                    'inline' => true,
                ],
                [
                    'name' => 'Updated',
                    'value' => '<t:' . round($experiment['updated']) . ':f> (<t:' . round($experiment['updated']) . ':R>)',
                    'inline' => true,
                ],
            ],
        ];

        $i++;
    }

    foreach ($experimentsUpdated as $experiment)
    {
        if($i > 10) break;

        if (($key = array_search($experiment, $experimentsUpdated)) !== false)
            unset($experimentsUpdated[$key]);

        $embed['embeds'][] = [
            'title' => $experiment['name'],
            'url' => 'https://discordlookup.com/experiment/' . $experiment['id'],
            'color' => 16705372,
            'author' => [
                'name' => 'Updated Experiment',
            ],
            'fields' => [
                [
                    'name' => 'Name',
                    'value' => $experiment['name'],
                    'inline' => true,
                ],
                [
                    'name' => 'ID',
                    'value' => $experiment['id'],
                    'inline' => true,
                ],
                [
                    'name' => 'Hash',
                    'value' => $experiment['hash'],
                    'inline' => true,
                ],
                [
                    'name' => 'Type',
                    'value' => ucwords($experiment['type']),
                    'inline' => true,
                ],
                [
                    'name' => 'Created',
                    'value' => '<t:' . round($experiment['created']) . ':f> (<t:' . round($experiment['created']) . ':R>)',
                    'inline' => true,
                ],
                [
                    'name' => 'Updated',
                    'value' => '<t:' . round($experiment['updated']) . ':f> (<t:' . round($experiment['updated']) . ':R>)',
                    'inline' => true,
                ],
            ],
        ];

        $i++;
    }

    Http::withBody(json_encode($embed), 'application/json')->post(env('EXPERIMENTS_WATCHER_WEBHOOK'));

    if(!empty($experimentsNew) || !empty($experimentsUpdated))
        postExperiments($experimentsNew, $experimentsUpdated);
}
