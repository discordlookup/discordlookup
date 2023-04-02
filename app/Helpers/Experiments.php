<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * @return array|mixed
 */
function getExperiments($experiment = 'all')
{
    if(!Cache::has('experiments:' . $experiment))
        fetchExperiments($experiment);

    return Cache::get('experiments:' . $experiment);
}

function fetchExperiments($experiment = 'all')
{
    $response = Http::timeout(10)->get(env('EXPERIMENTS_WORKER') . ($experiment == 'all' ? '' : '/' . $experiment));

    if($response->ok())
    {
        $responseJson = $response->json();
        Cache::put('experiments:' . $experiment, $responseJson, 15*60);
    }
}
