<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Experiments extends Component
{

    public $experimentsJson = [];
    public $experimentsJsonSearch = [];

    public $category = "all";
    public $search = "";
    public $order = "updated-desc";

    public function loadExperiments() {
        $this->experimentsJson = [];
        if(Cache::has('experimentsJson')) {
            $this->experimentsJson = Cache::get('experimentsJson');
        }else{
            $response = Http::get('https://experiments.fbrettnich.workers.dev/');
            if($response->ok()) {
                $this->experimentsJson = $response->json();
                Cache::put('experimentsJson', $this->experimentsJson, 900); // 15 minutes
            }
        }
    }

    public function changeCategory($category) {
        $this->category = $category;
    }

    public function updateCategory() {

        if($this->category == "all") return;

        $array = [];
        foreach ($this->experimentsJsonSearch as $experiment) {
            if ($this->category == "guild" && $experiment['type'] == "guild") {
                array_push($array, $experiment);
            }else if ($this->category == "user" && $experiment['type'] == "user") {
                array_push($array, $experiment);
            }
        }

        $this->experimentsJsonSearch = $array;
    }

    public function search() {
        $filterBy = $this->search;
        $this->experimentsJsonSearch = array_filter($this->experimentsJson, function ($var) use ($filterBy) {
            return (
                str_contains(strtolower($var['hash']), strtolower($filterBy)) ||
                str_contains(strtolower($var['id']), strtolower($filterBy)) ||
                str_contains(strtolower($var['name']), strtolower($filterBy))
            );
        });

        $this->updateCategory();

        $sortKey = explode('-', $this->order);
        if($sortKey[1] == "desc") {
            usort($this->experimentsJsonSearch, function($a, $b) use ($sortKey) {
                return $b[$sortKey[0]] <=> $a[$sortKey[0]];
            });
        }else{
            usort($this->experimentsJsonSearch, function($a, $b) use ($sortKey) {
                return $a[$sortKey[0]] <=> $b[$sortKey[0]];
            });
        }
    }

    public function mount() {
        $this->loadExperiments();
    }

    public function render()
    {
        $this->search();
        return view('livewire.experiments');
    }
}
