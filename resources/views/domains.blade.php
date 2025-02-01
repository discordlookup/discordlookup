<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Bad Domain Check') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <x-input-prepend-icon icon="fas fa-virus">
            <input
                wire:model.defer="domain"
                wire:keydown.enter="checkDomain"
                type="text"
                placeholder="{{ __('Domain') }}"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                data-1p-ignore
                autofocus
            />
        </x-input-prepend-icon>

        <button
            wire:click="checkDomain"
            wire:loading.class="border-[#414aa5] bg-[#414aa5] cursor-not-allowed"
            wire:loading.class.remove="border-discord-blurple bg-discord-blurple hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
            wire:loading.attr="disabled"
            type="button"
            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            <span wire:loading.remove>{{ __('Check Domain') }}</span>
            <span wire:loading><i class="fas fa-spinner fa-spin"></i> {{ __('Checking...') }}</span>
        </button>


        @if($domain && $isBadDomain)
            <x-error-message>
                <p>{{ __('This domain is on the bad domains list from Discord.') }}</p>
            </x-error-message>
        @elseif($domain && $isOfficialDomain)
            <x-success-message>
                <p>{{ __('This domain is an official Discord domain.') }}</p>
            </x-success-message>
        @elseif($domain && !$isBadDomain)
            <x-success-message>
                <p>{{ __('This domain is not on the bad domains list from Discord. However, this does not mean that this domain is automatically trustworthy. Be careful on which links you click!') }}</p>
            </x-success-message>
        @endif


    </div>
</div>
