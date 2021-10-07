<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@hasSection('title')@yield('title') | @endif{{ env('APP_NAME') }}</title>

    <link rel="icon" sizes="any" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.svg') }}"/>

    @hasSection('robots')<meta name="robots" content="@yield('robots')">@endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#5865F2">
    @hasSection('description')<meta name="description" content="@yield('description')">@endif

    <meta name="keywords" content="@hasSection('keywords')@yield('keywords'), @endif
discord, discord lookup, discordlookup, lookup, snowflake, guild count, invite info, user info, discord tools, tools">

    <meta property="og:site_name" content="DiscordLookup.com">
    <meta property="og:site" content="https://discordlookup.com/">
    <meta property="og:title" content="@yield('title') | {{ env('APP_NAME') }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    @hasSection('description')<meta property="og:description" content="@yield('description')">@endif

    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:image" content="{{ asset('images/logo-rounded.svg') }}">
    <meta property="og:type" content="website">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body class="d-flex flex-column h-100">
<main class="flex-shrink-0 mb-5">

    @include('components.navbar')

    <div>
        @yield('content')
    </div>
</main>

@include('components.footer')

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- TODO: Remove jquery --}}

@stack('scripts')

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
