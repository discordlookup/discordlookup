<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * @return array|mixed
 */
function getExperiments()
{
    $experimentsJson = [];
    if(Cache::has('experimentsJson')) {
        $experimentsJson = Cache::get('experimentsJson');
    }else{
        $response = Http::get(env('EXPERIMENTS_WORKER'));
        if($response->ok()) {
            $experimentsJson = $response->json();
            Cache::put('experimentsJson', $experimentsJson, 900); // 15 minutes
        }
    }
    return $experimentsJson;
}
