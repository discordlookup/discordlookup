@extends('layouts.app')

@section('title', __('Guild Lookup'))
@section('description', __('Get detailed information about Discord Guilds with creation date, Invite/Vanity URL, features and emojis.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('guild-lookup', ['snowflake' => $snowflake])
    </div>
@endsection
