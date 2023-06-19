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
discord, discord lookup, discordlookup, lookup, snowflake, guild count, invite info, user info, discord tools, tools">

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

    @foreach (Config::get('languages') as $lang => $language)
        <link rel="alternate" href="{{ route('language.switch', $lang) }}" hreflang="{{ $lang }}" />
    @endforeach

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body class="min-h-full bg-[#292b2f]">

@livewire('components.banners')

<main class="bg-discord-gray-2 text-white">

    @include('components.navbar')

    <div class="py-12 container xl:max-w-6xl mx-auto px-4 lg:px-10">
        @yield('content')
    </div>
</main>

@include('components.footer')

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@stack('scripts')
@livewire('modal.login')
@livewireScripts

@if(!empty(env('GOOGLETAGMANAGER_ID')))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLETAGMANAGER_ID') }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{{ env('GOOGLETAGMANAGER_ID') }}', {'anonymize_ip': true});
</script>
@endif

</body>
</html>
