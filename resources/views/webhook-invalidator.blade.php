@section('title', __('Discord Webhook Invalidator'))
@section('description', __('Immediately delete a Discord webhook to elemenate evil webhooks.'))
@section('keywords', 'webhook, invalidator, delete, delete webhook, invalidate webhook')
@section('robots', 'index, follow')

<div>
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Discord Webhook Invalidator') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3 mb-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="fas fa-link"></i>
                    </span>
                    <input id="webhookUrl" class="form-control form-control-lg" type="text" placeholder="{{ __('Discord Webhook URL') }}">
                </div>
            </div>

            <div id="alertInvalidUrl" class="col-12 col-lg-6 offset-lg-3" style="display: none">
                <div class="alert alert-danger fade show" role="alert">
                    {{ __('The entered link is not a valid Discord webhook URL.') }}
                </div>
            </div>

            <div id="alertDeleteFailed" class="col-12 col-lg-6 offset-lg-3" style="display: none">
                <div class="alert alert-danger fade show" role="alert">
                    {{ __('Deleting the Discord webhook failed. The webhook may have already been deleted or is invalid.') }}
                </div>
            </div>

            <div id="alertDeleted" class="col-12 col-lg-6 offset-lg-3" style="display: none">
                <div class="alert alert-success fade show" role="alert">
                    {{ __('The Discord webhook was successfully deleted.') }}
                </div>
            </div>

            <div class="col-12 col-lg-6 offset-lg-3">
                <button onclick="deleteWebhook()" type="button" class="btn btn-primary w-100 mt-3">{{ __('Delete Webhook') }}</button>
            </div>
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
