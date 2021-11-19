@extends('layouts.app')

@section('title', __('Application Lookup'))
@section('description', __('Get the creation date of a Snoflake, and detailed information about Discord applications.'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')
    <div class="container">
        @livewire('application-lookup', ['snowflake' => $snowflake])
    </div>
@endsection
