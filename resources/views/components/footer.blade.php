<footer class="py-4 mt-auto" style="background-color: #23272A">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md">
                <small class="d-block mt-2 text-white">&copy; {{ date('Y') }} {{ env('COPYRIGHT') }}</small>
                <small class="text-muted mt-n3">Not affiliated with Discord, Inc.</small>
            </div>
            <div class="col-6 col-md text-end align-self-center">
                <small class="d-block mb-3 mt-2">
                    <a class="text-white text-decoration-none" href="{{ route('legal.imprint') }}">{{ __('Imprint') }}</a>
                    {{-- <a class="text-white text-decoration-none ms-2" href="{{ route('legal.terms-of-service') }}">{{ __('Terms of Service') }}</a> --}}
                    <a class="text-white text-decoration-none ms-2" href="{{ route('legal.privacy') }}">{{ __('Privacy Policy') }}</a>
                </small>
            </div>
        </div>
    </div>
</footer>
