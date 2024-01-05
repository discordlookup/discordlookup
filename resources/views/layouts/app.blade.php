<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js h-100">
<head>
    <meta charset="utf-8">
    {!! meta()->toHtml() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" sizes="any" type="image/svg+xml" href="{{ asset('images/branding/favicon/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/branding/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/branding/favicon/favicon.png') }}"/>

    <meta name="og:image" content="{{ asset('images/branding/icon-blurple.png') }}">
    <meta name="og:site" content="{{ route('home') }}">
    <meta name="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="og:url" content="{{ Request::url() }}">

    <link rel="search" type="application/opensearchdescription+xml" title="DiscordLookup" href="/opensearch.xml">

    {{--
    @foreach (Config::get('languages') as $lang => $language)
        <link rel="alternate" href="{{ route('language.switch', $lang) }}" hreflang="{{ $lang }}" />
    @endforeach
    --}}

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body class="flex flex-col min-h-screen bg-[#292b2f]">

<main class="flex-grow bg-discord-gray-3 text-white">
    <x-navbar />
    <div class="py-12 container xl:max-w-7xl mx-auto px-4 lg:px-10">
        @yield('content')
    </div>
</main>

<x-footer />

<script src="{{ mix('js/app.js') }}" defer></script>

{{-- TODO: Remove jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@stack('scripts')
@livewireScripts

@if(!empty(env('PLAUSIBLE_URL')) && !empty(env('PLAUSIBLE_WEBSITE_DOMAIN')))
    <script defer data-domain="{{ env('PLAUSIBLE_WEBSITE_DOMAIN') }}" src="{{ env('PLAUSIBLE_URL') }}/js/script.js"></script>
@endif

</body>
</html>
