@extends('layouts.app')

@section('title', __('User Lookup'))
@section('description', __('Get the creation date of a Snoflake, and detailed information about Discord users.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('user-lookup', ['snowflake' => $snowflake])
    </div>
@endsection
