@extends('layouts.app')

@section('title', __('Discord Experiments & Rollouts'))
@section('description', __('All Discord Client & Guild Experiments with Rollout Status and detailed information about Treatments, Groups and Overrides.'))
@section('keywords', 'client, guild, experiments, discord experiments, rollout, rollouts, treatments, groups, overrides, population')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('experiments')
    </div>
@endsection
