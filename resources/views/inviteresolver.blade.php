@extends('layouts.app')

@section('title', __('Invite Resolver'))
@section('description', __('Get detailed information about every invite and vanity url including event information.'))
@section('keywords', 'event, vanity')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('invite-resolver', ['inviteCode' => $code, 'eventId' => $eventId])
    </div>
@endsection
