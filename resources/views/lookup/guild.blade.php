@section('title', __('Guild Lookup'))
@section('description', __('Get detailed information about Discord guilds with creation date, Invite/Vanity URL, features and emojis.'))
@section('keywords', '')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Guild Lookup') }}</h2>
    <div class="py-12 xl:max-w-3xl mx-auto px-4 lg:px-10 space-y-3">
        <x-input-prepend-icon icon="far fa-snowflake">
            <input
                wire:model="snowflake"
                wire:keydown.enter="fetchGuild"
                type="number"
                placeholder="{{ __('Guild ID') }}"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
            />
        </x-input-prepend-icon>

        <button wire:click="fetchGuild" type="button" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
            {{ __('Fetch Discord Information') }}
        </button>

        @if($errorMessage)
            <x-error-message>
                {{ $errorMessage }}
            </x-error-message>
        @endif

        @if($rateLimitHit)
            <x-error-message>
                {{ __('You send too many requests!') }}
                @auth
                    {{ __('Please try again in :SECONDS seconds.', ['seconds' => $rateLimitAvailableIn ]) }}
                @endauth
                @guest
                    {{ __('Please try again in :SECONDS seconds or log in with your Discord account to increase the limit.', ['seconds' => $rateLimitAvailableIn ]) }}
                @endguest
            </x-error-message>
        @endif

        @if($guildData)
            <x-guild-card :guild="$guildData" invite-type="0" />

            @if(array_key_exists('emojis', $guildData) && !empty($guildData['emojis']))
                <x-emoji-card :emojis="$guildData['emojis']" />
            @endif

            @if(array_key_exists('stickers', $guildData) && !empty($guildData['stickers']))
                <x-sticker-card :stickers="$guildData['stickers']" />
            @endif
        @endif

        @if($snowflakeDate && empty($guildData))
            <x-error-message>
                <p>{{ __('No Discord guild could be found for the entered Snowflake.') }}</p>
                <p>{{ __('It is possible that the entered guild has disabled the server widget and discovery.') }}</p>
                <p>{!! __('If you want to search for a :user or :application instead, check out our other tools.', ['user' => '<a href="' . route('userlookup', ['snowflake' => $snowflake]) . '" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">user</a>', 'application' => '<a href="' . route('applicationlookup', ['snowflake' => $snowflake]) . '" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">application</a>']) !!}</p>
            </x-error-message>
        @endif
    </div>

    <script>
        @if($guildData && array_key_exists('instantInviteUrlCode', $guildData))
            document.addEventListener('DOMContentLoaded', () => getInviteInfo('{{ $guildData['instantInviteUrlCode'] }}'));
        @endif
        window.addEventListener('getInviteInfo', event => getInviteInfo(event.detail.inviteCode));

        function getInviteInfo(inviteCode)
        {
            if(!inviteCode) return;
            $.ajax({
                type: 'GET',
                url: '{{ env('DISCORD_API_URL') }}/invites/' + inviteCode + '?with_counts=true&with_expiration=true',
                success: (respond) => Livewire.emit('processInviteJson', respond),
                error: () => Livewire.emit('processInviteJson', null),
            });
        }
    </script>
</div>
