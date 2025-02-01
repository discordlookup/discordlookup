<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Domains extends Component
{
    public $badDomainsHashes = [];

    public $domain;
    public $isBadDomain = false;
    public $isOfficialDomain = false;

    public function checkDomain()
    {
        $this->isOfficialDomain = false;
        if (filter_var($this->domain, FILTER_VALIDATE_URL)) {
            $this->domain = parse_url($this->domain, PHP_URL_HOST);
        }

        $hash = hash('sha256', $this->domain);
        $this->isBadDomain = in_array($hash, $this->badDomainsHashes);

        foreach (getOfficialDiscordDomains() as $officialDomain) {
            if (strtolower($this->domain) == strtolower($officialDomain) || str_ends_with(strtolower($this->domain), "." . strtolower($officialDomain))) {
                $this->isOfficialDomain = true;
                return;
            }
        }
    }

    public function mount()
    {
        if(Cache::has('bad-domains')) {
            $this->badDomainsHashes = Cache::get('bad-domains');
        }else{
            $response = Http::timeout(5)
                ->withUserAgent('DiscordBot (https://discordlookup.com/, 1.0)')
                ->get(config('discord.cdn_url') . '/bad-domains/hashes.json');

            if($response->ok())
            {
                $responseJson = $response->json();
                $this->badDomainsHashes = $responseJson;
                Cache::put('bad-domains', $responseJson, 900); // 15 minutes
            }
        }

        Meta::set('title', __('Bad Domain Check'))
            ->set('og:title', __('Bad Domain Check'))
            ->set('description', __('Check if a domain is listed as a bad domain on Discord.'))
            ->set('og:description', __('Check if a domain is listed as a bad domain on Discord.'))
            ->set('keywords', 'bad, bad domain, bad domains, ' . getDefaultKeywords());
    }

    public function render()
    {
        return view('domains')->extends('layouts.app');
    }
}
