@extends('layouts.app')

@section('title', __('User Lookup'))
@section('description', __('Get detailed information about Discord users with creation date, profile picture, banner and badges.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('user-lookup', ['snowflake' => $snowflake])
    </div>
@endsection
