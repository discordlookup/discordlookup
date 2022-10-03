@extends('layouts.app')

@section('title', __('Imprint'))
@section('description', __('Legal Provider Identification of DiscordLookup.com'))
@section('keywords', 'imprint, legal')
@section('robots', 'noindex, nofollow')

@section('content')

    <div class="container mt-5">
        <div class="page-header mt-2">
            <h2 class="pb-2 fw-bold">{{ __('Imprint') }}</h2>
        </div>

        <div class="user-select-none">
            @if(\Illuminate\Support\Facades\View::exists('legal.content.imprint'))
                @include('legal.content.imprint')
            @endif
        </div>

        <br>
        <br>

        <h3>{{ __('Disclaimer') }}</h3>
        <div>
            {{ __('DiscordLookup is not affiliated, associated, authorized, endorsed by, or in anyway officially connected with Discord Inc., or any of its subsidiaries or its affiliates.') }}
            <br>
            {{ __('Any new products or features discovered are subject to change and not guaranteed to release.') }}
        </div>
    </div>

@endsection
