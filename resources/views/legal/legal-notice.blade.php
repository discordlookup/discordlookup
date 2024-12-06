<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Legal Notice') }}</h2>
    <div class="py-12">
        <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
            <div class="p-5 lg:p-6 grow w-full space-y-8 select-none">
                <div class="space-y-3">
                    <div>
                        <h3 class="text-xl font-bold mb-2">{{ __('Legal Notice') }}</h3>
                        <div>{{ config('app.legal_firstname') }} {{ config('app.legal_lastname') }}</div>
                        <div>{{ config('app.legal_address') }}</div>
                        @if(config('app.legal_address_additional'))
                            <div>{{ config('app.legal_address_additional') }}</div>
                        @endif
                        <div>{{ config('app.legal_zipcode') }} {{ config('app.legal_city') }}</div>
                        <div>{{ config('app.legal_country') }}</div>
                    </div>

                    <div>
                        <div>{{ __('E-Mail') }}: <a href="mailto:{{ config('app.legal_email') }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ config('app.legal_email') }}</a></div>
                        <div>{{ __('Phone') }}: <a href="tel:{{ config('app.legal_phone') }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">{{ config('app.legal_phone') }}</a></div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-2">Validy of this legal notice</h3>
                    <div>
                        This legal notice applies to the following websites including subdomains, social media accounts and other services, as long as they are listed here:
                        <ul class="list-disc list-inside mt-1">
                            <li><a href="https://discordlookup.com/" target="_blank">https://discordlookup.com/</a></li>
                            <li>
                                <a href="https://github.com/discordlookup" target="_blank">https://github.com/discordlookup</a>
                            </li>
                            <li>
                                <a href="https://twitter.com/discordlookup" target="_blank">https://twitter.com/discordlookup</a>
                            </li>
                            <li>
                                <a href="https://discordlookup.com/invite" target="_blank">DiscordLookup#2990 bot user on Discord</a>
                                <small>(ID: <a href="{{ route('userlookup', ['snowflake' => '892399371910524938']) }}">892399371910524938</a>)</small>
                            </li>
                            <li>
                                <a href="https://discordlookup.com/discord" target="_blank">DiscordLookup server on Discord</a>
                                <small>(ID: <a href="{{ route('guildlookup', ['snowflake' => '980791496833908778']) }}">980791496833908778</a>)</small>
                            </li>
                        </ul>
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
