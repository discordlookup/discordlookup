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
    </div>

@endsection
