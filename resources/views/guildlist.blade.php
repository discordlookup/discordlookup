@extends('layouts.app')

@section('title', __('Guild List'))
@section('description', __('Show all the guilds you are on, with counters, permissions, features and more information about the guilds.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('guildlist')
    </div>

    @livewire('guild-features-modal')
    @livewire('guild-permissions-modal')
    @livewire('guild-experiments-modal')
@endsection
