@extends('layouts.app')

@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('experiment', ['experimentId' => $experimentId])
    </div>
@endsection
