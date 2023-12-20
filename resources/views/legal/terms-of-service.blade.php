@extends('layouts.app')

@section('title', __('Terms of Service'))
@section('description', __('Terms of Service of DiscordLookup.com'))
@section('keywords', 'terms, service, terms of service, terms of use, use, legal')
@section('robots', 'noindex, nofollow')

@section('content')
    <div>
        <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Terms of Service') }}</h2>
        <div class="py-12">
            @if(\Illuminate\Support\Facades\View::exists('legal.content.terms-of-service'))
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="p-5 lg:p-6 grow w-full space-y-8 select-none">
                        @include('legal.content.terms-of-service')
                    </div>
                </div>
            @else
                <x-error-message>
                    Failed to load Terms of Service content.
                </x-error-message>
            @endif
        </div>
    </div>
@endsection
