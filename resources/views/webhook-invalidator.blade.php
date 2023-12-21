@section('title', __('Discord Webhook Invalidator'))
@section('description', __('Immediately delete a Discord webhook to eliminate evil webhooks.'))
@section('keywords', 'webhook, invalidator, delete, delete webhook, invalidate webhook')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Discord Webhook Invalidator') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <x-input-prepend-icon icon="fas fa-link">
            <input
                id="webhookUrl"
                type="text"
                placeholder="{{ __('Discord Webhook URL') }}"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </x-input-prepend-icon>

        <button onclick="deleteWebhook()" type="button" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
            {{ __('Delete Webhook') }}
        </button>

        <div id="alertInvalidUrl" style="display: none">
            <x-error-message>
                {{ __('The entered link is not a valid Discord webhook URL.') }}
            </x-error-message>
        </div>

        <div id="alertDeleteFailed" style="display: none">
            <x-error-message>
                {{ __('Deleting the Discord webhook failed. The webhook may have already been deleted or is invalid.') }}
            </x-error-message>
        </div>

        <div id="alertDeleted" style="display: none">
            <x-success-message>
                {{ __('The Discord webhook was successfully deleted.') }}
            </x-success-message>
        </div>
    </div>


    <script>
        const deleteWebhook = () => {
            const [alertInvalidUrl, alertDeleted, alertDeleteFailed] = ['alertInvalidUrl', 'alertDeleted', 'alertDeleteFailed'].map(e => document.getElementById(e));

            [alertInvalidUrl, alertDeleted, alertDeleteFailed].forEach(e => e.style.display = 'none');

            const url = document.getElementById('webhookUrl').value;
            if (!url) return;

            const regex = /^(https?:\/\/)(www\.|canary\.|ptb\.)?(discord(?:app)?\.com)\/api(\/v\d{1,2})?\/webhooks\/\d{17,19}\/[a-z0-9_]+/i;
            if (!regex.test(url)) return alertInvalidUrl.style.display = '';

            $.ajax({
                type: 'DELETE',
                url,
                success: () => alertDeleted.style.display = '',
                error: () => alertDeleteFailed.style.display = '',
            });
        }
    </script>
</div>
