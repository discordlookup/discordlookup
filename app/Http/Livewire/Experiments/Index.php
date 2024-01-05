<?php

namespace App\Http\Livewire\Experiments;

use F9Web\Meta\Meta;
use Livewire\Component;

class Index extends Component
{
    public $experimentsJson = [];
    public $experimentsJsonSearch = [];

    public $category = 'all';
    public $search = '';
    public $sorting = 'id-desc';

    public function loadExperiments()
    {
        $this->experimentsJson = getExperiments();
    }

    public function changeCategory($category)
    {
        $this->category = $category;
    }

    public function updateCategory()
    {
        if($this->category == 'all') return;

        $array = [];
        foreach ($this->experimentsJsonSearch as $experiment)
        {
            if ($this->category == 'guild' && $experiment['type'] == 'guild')
                $array[] = $experiment;

            else if ($this->category == 'user' && $experiment['type'] == 'user')
                $array[] = $experiment;
        }

        $this->experimentsJsonSearch = $array;
    }

    public function search()
    {
        $filterBy = $this->search;
        $this->experimentsJsonSearch = array_filter($this->experimentsJson, function ($var) use ($filterBy) {
            return (
                str_contains(strtolower($var['hash']), strtolower($filterBy)) ||
                str_contains(strtolower($var['id']), strtolower($filterBy)) ||
                str_contains(strtolower($var['title']), strtolower($filterBy))
            );
        });

        $this->updateCategory();

        $sortKey = explode('-', $this->sorting);
        if($sortKey[1] == 'desc') {
            usort($this->experimentsJsonSearch, function($a, $b) use ($sortKey) {
                return $b[$sortKey[0]] <=> $a[$sortKey[0]];
            });
        }else{
            usort($this->experimentsJsonSearch, function($a, $b) use ($sortKey) {
                return $a[$sortKey[0]] <=> $b[$sortKey[0]];
            });
        }
    }

    public function mount()
    {
        $this->loadExperiments();

        Meta::set('title', __('Discord Experiments & Rollouts'))
            ->set('og:title', __('Discord Experiments & Rollouts'))
            ->set('description', __('All Discord Client & Guild Experiments with Rollout Status and detailed information about Treatments, Groups and Overrides.'))
            ->set('og:description', __('All Discord Client & Guild Experiments with Rollout Status and detailed information about Treatments, Groups and Overrides.'))
            ->set('keywords', 'client, guild, experiments, discord experiments, rollout, rollouts, treatments, groups, overrides, population, ' . getDefaultKeywords());
    }

    public function render()
    {
        $this->search();
        return view('experiments.index')->extends('layouts.app');
    }
}
