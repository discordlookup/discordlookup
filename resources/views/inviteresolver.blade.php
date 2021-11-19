@extends('layouts.app')

@section('title', __('Invite Resolver'))
@section('description', __('Get detailed information about every invite and vanity url.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('invite-resolver', ['inviteCode' => $code])
    </div>
@endsection
