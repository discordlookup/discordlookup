@extends('layouts.app')

@section('title', __('Guild Lookup'))
@section('description', __('Get the creation date of a Snoflake, and detailed information about Discord guilds.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('guild-lookup', ['snowflake' => $snowflake])
    </div>
@endsection
