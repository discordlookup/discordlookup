@extends('layouts.app')

@section('title', __('Privacy Policy'))
@section('description', __('Privacy Policy of DiscordLookup.com'))
@section('keywords', 'privacy, policy, legal')
@section('robots', 'noindex, nofollow')

@section('content')
    <div>
        <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Privacy Policy') }}</h2>
        <div class="py-12">
            @if(\Illuminate\Support\Facades\View::exists('legal.content.privacy-policy'))
                <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                    <div class="p-5 lg:p-6 grow w-full space-y-8 select-none">
                        @include('legal.content.privacy-policy')
                    </div>
                </div>
            @else
                <x-error-message>
                    Failed to load Privacy Policy content.
                </x-error-message>
            @endif
        </div>
    </div>
@endsection
