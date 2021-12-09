@extends('layouts.app')

@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('experiment', ['experimentId' => $experimentId])
    </div>

    @livewire('guild-features-modal')
    @livewire('guild-permissions-modal')
    @livewire('guild-experiments-modal')
@endsection
