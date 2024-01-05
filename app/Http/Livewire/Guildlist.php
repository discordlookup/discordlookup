<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;

class Guildlist extends Component
{
    public $guildsJson = [];
    public $guildsJsonSearch = [];

    public $countGuilds = 0;
    public $countOwner = 0;
    public $countAdministrator = 0;
    public $countModerator = 0;
    public $countVerified = 0;
    public $countPartnered = 0;
    public $countVanityUrl = 0;
    public $countCommunityEnabled = 0;
    public $countDiscoveryEnabled = 0;
    public $countWelcomeScreenEnabled = 0;

    public $category = 'all';
    public $search = '';
    public $sorting = 'name-asc';

    public function loadGuilds()
    {
        $this->guildsJson = auth()->user()->guildList;

        if(key_exists('message', $this->guildsJson)) {
            $this->redirect(route('login'));
            return;
        }

        if($this->guildsJson != null)
        {
            foreach ($this->guildsJson as $guild)
            {
                $this->countGuilds++;

                if(array_key_exists('owner', $guild) && $guild['owner']) $this->countOwner++;

                if(array_key_exists('permissions', $guild)) {
                    if (hasAdministrator($guild['permissions'])) $this->countAdministrator++;
                    if (hasModerator($guild['permissions'])) $this->countModerator++;
                }

                if(array_key_exists('features', $guild)) {
                    if (in_array('VERIFIED', $guild['features'])) $this->countVerified++;
                    if (in_array('PARTNERED', $guild['features'])) $this->countPartnered++;
                    if (in_array('VANITY_URL', $guild['features'])) $this->countVanityUrl++;
                    if (in_array('COMMUNITY', $guild['features'])) $this->countCommunityEnabled++;
                    if (in_array('DISCOVERABLE', $guild['features'])) $this->countDiscoveryEnabled++;
                    if (in_array('WELCOME_SCREEN_ENABLED', $guild['features'])) $this->countWelcomeScreenEnabled++;
                }
            }

            $this->countAdministrator -= $this->countOwner;
            $this->countModerator = $this->countModerator - $this->countOwner - $this->countAdministrator;
        }
    }

    public function changeCategory($category)
    {
        $this->category = $category;
        $this->dispatchBrowserEvent('scrollToSearch');
    }

    public function updateCategory()
    {
        if($this->category == 'all') return;

        $array = [];
        foreach ($this->guildsJsonSearch as $guild)
        {
            if ($this->category == 'owner' && $guild['owner'])
                $array[] = $guild;

            if ($this->category == 'administrator' && !$guild['owner'] && hasAdministrator($guild['permissions']))
                $array[] = $guild;

            if ($this->category == 'moderator' && !$guild['owner'] && !hasAdministrator($guild['permissions']) && hasModerator($guild['permissions']))
                $array[] = $guild;

            if(array_key_exists('features', $guild))
            {
                if ($this->category == 'verified' && in_array('VERIFIED', $guild['features']))
                    $array[] = $guild;

                if ($this->category == 'partnered' && in_array('PARTNERED', $guild['features']))
                    $array[] = $guild;

                if ($this->category == 'vanityurl' && in_array('VANITY_URL', $guild['features']))
                    $array[] = $guild;

                if ($this->category == 'community' && in_array('COMMUNITY', $guild['features']))
                    $array[] = $guild;

                if ($this->category == 'discovery' && in_array('DISCOVERABLE', $guild['features']))
                    $array[] = $guild;

                if ($this->category == 'welcomescreen' && in_array('WELCOME_SCREEN_ENABLED', $guild['features']))
                    $array[] = $guild;
            }
        }

        $this->guildsJsonSearch = $array;
    }

    public function search()
    {
        $filterBy = $this->search;
        $this->guildsJsonSearch = array_filter($this->guildsJson, function ($var) use ($filterBy) {
            return (
                str_contains(strtolower($var['id']), strtolower($filterBy)) ||
                str_contains(strtolower($var['name']), strtolower($filterBy))
            );
        });

        $this->updateCategory();

        $sortKey = explode('-', $this->sorting);
        if($sortKey[1] == 'desc') {
            usort($this->guildsJsonSearch, function($a, $b) use ($sortKey) {
                return $b[$sortKey[0]] <=> $a[$sortKey[0]];
            });
        }else{
            usort($this->guildsJsonSearch, function($a, $b) use ($sortKey) {
                return $a[$sortKey[0]] <=> $b[$sortKey[0]];
            });
        }
    }

    public function mount()
    {
        if(auth()->check())
            $this->loadGuilds();

        Meta::set('title', __('Guild List'))
            ->set('og:title', __('Guild List'))
            ->set('description', __('Show all the guilds you are on, with counters, permissions, features, experiments and more information about the guilds.'))
            ->set('og:description', __('Show all the guilds you are on, with counters, permissions, features, experiments and more information about the guilds.'))
            ->set('keywords', getDefaultKeywords());
    }

    public function render()
    {
        if(auth()->check())
            $this->search();

        return view('guildlist')->extends('layouts.app');
    }
}
