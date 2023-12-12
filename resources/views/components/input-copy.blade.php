<div>
    <div class="flex items-center">
        <input
            id="input{{ $hash }}"
            class="block border-none rounded-l z-1 px-3 py-2 leading-5 text-sm w-full bg-discord-gray-3 focus:outline-none focus:ring-0 -mr-px"
            type="text"
            value="{{ $value }}"
            readonly
        />
        <button
            onclick="copyToClipboard('input{{ $hash }}', 'success{{ $hash }}')"
            type="button"
            class="inline-flex justify-center items-center space-x-2 border font-semibold px-3 py-2.5 leading-6 text-sm rounded-r border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            <i class="far fa-clipboard"></i>
        </button>
    </div>

    <p id="success{{ $hash }}" class="text-xs text-green-500 mt-1 hidden">{{ __('Successfully copied to the clipboard.') }}</p>
</div>
