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
            @include('legal.content.imprint')
        </div>
    </div>

@endsection
