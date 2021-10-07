@extends('layouts.app')

@section('title', __('Snowflake'))
@section('description', __('Get the creation date of a Snoflake, and detailed information about Discord users and guilds.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('snowflake-search', ['snowflake' => $snowflake])
    </div>
@endsection
