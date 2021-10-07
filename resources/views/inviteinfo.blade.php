@extends('layouts.app')

@section('title', __('Invite Info'))
@section('description', __('Get detailed information about every invite and vanity url.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('inviteinfo', ['inviteCode' => $code])
    </div>
@endsection
