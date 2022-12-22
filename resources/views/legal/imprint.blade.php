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
            <h3>{{ __('Legal Provider Identification:') }}</h3>
            {{ env('LEGAL_FIRSTNAME') }} {{ env('LEGAL_LASTNAME') }}<br>
            {{ env('LEGAL_STREET') }} {{ env('LEGAL_STREET_NUMBER') }}<br>
            {{ env('LEGAL_ZIPCODE') }} {{ env('LEGAL_CITY') }}<br>
            {{ env('LEGAL_COUNTRY') }}<br>
            <br>
            {{ __('Phone') }}: <a href="tel:{{ env('LEGAL_PHONE') }}">{{ env('LEGAL_PHONE') }}</a><br>
            {{ __('E-Mail') }}: <a href="mailto:{{ env('LEGAL_EMAIL') }}">{{ env('LEGAL_EMAIL') }}</a><br>
            <br>
            <b>{!! __('Responsible for content according to &sect; 18 para. 2 MStV:') !!}</b><br>
            {{ env('LEGAL_FIRSTNAME') }} {{ env('LEGAL_LASTNAME') }}<br>
            {{ env('LEGAL_STREET') }} {{ env('LEGAL_STREET_NUMBER') }}<br>
            {{ env('LEGAL_ZIPCODE') }} {{ env('LEGAL_CITY') }}<br>
            {{ env('LEGAL_COUNTRY') }}<br>
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
