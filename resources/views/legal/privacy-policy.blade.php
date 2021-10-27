@extends('layouts.app')

@section('title', __('Privacy Policy'))
@section('description', __('Privacy Policy of DiscordLookup.com'))
@section('keywords', 'privacy, policy, legal')
@section('robots', 'noindex, nofollow')

@section('content')

    <div class="container mt-5">
        <div class="page-header mt-2">
            <h2 class="pb-2 fw-bold">{{ __('Privacy Policy') }}</h2>
        </div>

        <div class="user-select-none">
            @if(\Illuminate\Support\Facades\View::exists('legal.content.privacy-policy'))
                @include('legal.content.privacy-policy')
            @endif
        </div>
    </div>

@endsection
