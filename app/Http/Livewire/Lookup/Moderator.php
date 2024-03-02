<?php

namespace App\Http\Livewire\Lookup;

use F9Web\Meta\Meta;
use Livewire\Component;

class Moderator extends Component
{
    public $snowflake;

    public $guildsJson = [];
    public $guildsJsonSearch = [];

    public $countGuilds = 0;
    public $countOwner = 0;
    public $countAdministrator = 0;
    public $countModerator = 0;

    public $category = 'all';
    public $search = '';
    public $sorting = 'name-asc';

    public function loadGuilds()
    {
        if (!$this->snowflake) return;
        $this->guildsJson = \App\Models\User::firstWhere('discord_id', '=', $this->snowflake)->guildList;

        if(key_exists('message', $this->guildsJson)) return;

        if($this->guildsJson != null)
        {
            $array = [];
            foreach ($this->guildsJson as $guild)
            {
                $this->countGuilds++;
                $addGuild = false;

                if(array_key_exists('owner', $guild) && $guild['owner']) {
                    $this->countOwner++;
                    $addGuild = true;
                }

                if(array_key_exists('permissions', $guild)) {
                    if (hasAdministrator($guild['permissions'])) {
                        $this->countAdministrator++;
                        $addGuild = true;
                    }
                    if (hasModerator($guild['permissions'])) {
                        $this->countModerator++;
                        $addGuild = true;
                    }
                }

                if ($addGuild) $array[] = $guild;
            }
            $this->guildsJson = $array;

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

        Meta::set('title', __('Moderator Lookup'))
            ->set('og:title', __('Moderator Lookup'))
            ->set('description', __(''))
            ->set('og:description', __(''))
            ->set('keywords', getDefaultKeywords());
    }

    public function render()
    {
        if(auth()->check())
            $this->search();

        return view('lookup.moderator')->extends('layouts.app');
    }
}
