@extends('layouts.app')

@section('title', __('Imprint'))
@section('description', __('Legal Provider Identification of DiscordLookup.com'))
@section('keywords', 'imprint, legal')
@section('robots', 'noindex, nofollow')

@section('content')
    <div>
        <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Imprint') }}</h2>
        <div class="py-12">
            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                <div class="p-5 lg:p-6 grow w-full space-y-8 select-none">
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-xl font-bold mb-2">{{ __('Legal Provider Identification') }}</h3>
                            <div>{{ env('LEGAL_FIRSTNAME') }} {{ env('LEGAL_LASTNAME') }}</div>
                            <div>{{ env('LEGAL_STREET') }} {{ env('LEGAL_STREET_NUMBER') }}</div>
                            <div>{{ env('LEGAL_ZIPCODE') }} {{ env('LEGAL_CITY') }}</div>
                            <div>{{ env('LEGAL_COUNTRY') }}</div>
                        </div>

                        <div>
                            <div>{{ __('Phone') }}: <a href="tel:{{ env('LEGAL_PHONE') }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ env('LEGAL_PHONE') }}</a></div>
                            <div>{{ __('E-Mail') }}: <a href="mailto:{{ env('LEGAL_EMAIL') }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ env('LEGAL_EMAIL') }}</a></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-2">{{ __('Disclaimer') }}</h3>
                        <div>{{ __('DiscordLookup is not affiliated, associated, authorized, endorsed by, or in anyway officially connected with Discord Inc., or any of its subsidiaries or its affiliates.') }}</div>
                        <div>{{ __('Any new products or features discovered are subject to change and not guaranteed to release.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
