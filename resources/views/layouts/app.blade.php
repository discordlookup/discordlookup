<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@hasSection('title')@yield('title') | @endif{{ env('APP_NAME') }}</title>

    <link rel="icon" sizes="any" type="image/svg+xml" href="{{ asset('images/branding/favicon/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/branding/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/branding/favicon/favicon.png') }}"/>

    @hasSection('robots')<meta name="robots" content="@yield('robots')">@endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('themecolor')
        <meta name="theme-color" content="@yield('themecolor')">
    @else
        <meta name="theme-color" content="#5865F2">
    @endif
    @hasSection('description')<meta name="description" content="@yield('description')">@endif

    <meta name="keywords" content="@hasSection('keywords')@yield('keywords'), @endif
discord, discord lookup, discordlookup, lookup, snowflake, toolbox, tool box, guild count, invite info, user info, discord tools, tools, experiments, rollouts, search, discord search">

    @hasSection('og.sitename')
        <meta property="og:site_name" content="@yield('og.sitename')">
    @else
        <meta property="og:site_name" content="DiscordLookup.com">
    @endif
    @hasSection('og.title')
        <meta property="og:title" content="@yield('og.title')">
    @else
        <meta property="og:title" content="@yield('title') | {{ env('APP_NAME') }}">
    @endif
    @hasSection('og.image')
        <meta property="og:image" content="@yield('og.image')">
    @else
        <meta property="og:image" content="{{ asset('images/branding/icon-blurple.png') }}">
    @endif
    @hasSection('og.description')
        <meta property="og:description" content="@yield('og.description')">
    @else
        @hasSection('description')
            <meta property="og:description" content="@yield('description')">
        @endif
    @endif

    <meta property="og:site" content="{{ route('home') }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:type" content="website">

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
