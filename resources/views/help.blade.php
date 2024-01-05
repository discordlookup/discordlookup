<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('DiscordLookup Help') }}</h2>
    <div class="text-center">
        <a role="button" href="{{ env('DISCORD_URL') }}" target="_blank" rel="noopener" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-4 py-2 leading-6 border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
            <i class="fab fa-discord"></i> {{ __('Support Discord') }}
        </a>
    </div>
    <div class="py-12 space-y-3">
        <x-help-card :title="__('What is a Snowflake and how do I find one?')">
            <div class="space-y-3">
                <div>
                    <p>A Snowflake is essentially a unique ID for a Discord resource which contains a timestamp.</p>
                    <p>Each guild, user, channel, message, emoji and role has its own unique Snowflake ID.</p>
                    <p>You can use the Snowflake ID to search for users and guilds or just show the creation date.</p>
                </div>

                <p>To find out an ID from a Guild/User/Message, do the following:</p>

                <ol class="list-inside list-decimal space-y-1.5 ml-3">
                    <li>Make sure you have enabled Discord Developer mode:
                        <ul class="list-inside list-disc ml-5">
                            <li><span class="font-semibold">Desktop:</span> Go to <span class="font-mono text-discord-fuchsia">User Settings</span> => <span class="font-mono text-discord-fuchsia">Advanced</span> and enable <span class="font-mono text-discord-fuchsia">Developer Mode</span></li>
                            <li><span class="font-semibold">Mobile:</span> Go to <span class="font-mono text-discord-fuchsia">User Settings</span> => <span class="font-mono text-discord-fuchsia">Behavior</span> and enable <span class="font-mono text-discord-fuchsia">Developer Mode</span></li>
                        </ul>
                    </li>
                    <li>Go to a guild/member/message and right click <span class="italic">(mobile long click)</span> on it</li>
                    <li>Now you can click <span class="font-mono text-discord-fuchsia">Copy ID</span> at the bottom and you have successfully copied the Snowflake ID.</li>
                </ol>

                <div class="italic">
                    <p>You can also find a video tutorial on YouTube: <a href="https://youtu.be/404AT9WeBZM?t=50" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">https://youtu.be/404AT9WeBZM?t=50</a><br></p>
                    <p>If you want to learn more about Snowflakes visit the <a href="https://discord.com/developers/docs/reference#snowflakes" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">Discord Developer Documentation</a>.</p>
                </div>
            </div>
        </x-help-card>

        <x-help-card :title="__('Why some guilds can\'t be found by their ID/Snowflake?')">
            <p>Guild information can only be displayed if that Guild has the widget and/or Discovery enabled.</p>
            <p>Because the widget is off by default, many guilds cannot be loaded.</p>
            <p>Guilds with more than 1,000 members usually have Discovery enabled and can be loaded without problems.</p>
            <br>
            <p>To enable the server widget, go to <span class="font-mono text-discord-fuchsia">Server Settings</span> => <span class="font-mono text-discord-fuchsia">Widget</span> => <span class="font-mono text-discord-fuchsia">Enable Server Widget</span> <span class="font-semibold">and</span> select a channel under <span class="font-mono text-discord-fuchsia">Invite Channel</span>.</p>
        </x-help-card>

        <x-help-card :title="__('How are my personal stats calculated in the Guild List?')">
            <div class="space-y-1">
                <p>
                    <img src="{{ asset('images/discord/icons/server/owner.svg') }}" class="inline-block w-4 h-4" alt="owner badge">
                    <span class="font-semibold">{{ __('You own') }}:</span> Here are servers listed that you own completely (owner)
                </p>
                <p>
                    <img src="{{ asset('images/discord/icons/server/administrator.svg') }}" class="inline-block w-4 h-4" alt="administrator badge">
                    <span class="font-semibold">{{ __('You administrate') }}:</span> Here are listed servers on which you have the <span class="font-mono text-discord-fuchsia">ADMINISTRATOR</span> permission
                </p>
                <div>
                    <p>
                        <img src="{{ asset('images/discord/icons/server/moderator.svg') }}" class="inline-block w-4 h-4" alt="moderator badge">
                        <span class="font-semibold">{{ __('You moderate') }}:</span> Here are listed servers on which you have at least one of the following permissions:
                    </p>
                    <p>
                        <span class="font-mono text-discord-fuchsia">KICK_MEMBERS</span>,
                        <span class="font-mono text-discord-fuchsia">BAN_MEMBERS</span>,
                        <span class="font-mono text-discord-fuchsia">MANAGE_CHANNELS</span>,
                        <span class="font-mono text-discord-fuchsia">MANAGE_GUILD</span>,
                        <span class="font-mono text-discord-fuchsia">MANAGE_MESSAGES</span>,
                        <span class="font-mono text-discord-fuchsia">MANAGE_NICKNAMES</span>,
                        <span class="font-mono text-discord-fuchsia">MANAGE_ROLES</span>,
                        <span class="font-mono text-discord-fuchsia">MANAGE_WEBHOOKS</span>,
                        <span class="font-mono text-discord-fuchsia">MANAGE_THREADS</span>
                    </p>
                </div>
            </div>
            <br>
            <p>If a guild is already counted in a higher category, it will not be counted again.</p>
            <p>For example, guilds on which you have <span class="font-mono text-discord-fuchsia">ADMINISTRATOR</span> and <span class="font-mono text-discord-fuchsia">MANAGE_MESSAGES</span> permissions only count towards "You administrate".</p>
        </x-help-card>

        <x-help-card :title="__('I need support or have bugs/feature requests')">
            Visit our <a href="{{ env('DISCORD_URL') }}" target="_blank" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">Discord server</a>. We will be happy to help you there as soon as possible.
        </x-help-card>

        <x-help-card :title="__('What happens to my data when I login with Discord?')">
            <p>When you log in, Discord sends your full username, avatar and banner, as well as a list of guilds you are on at the time of login.</p>
            <p>We do not receive your email address or other data from Discord.</p>
            <p>The list of your guilds is not stored by us and is only associated with your current session. As soon as you log out or close your browser, this list is automatically deleted.</p>
            <p>For more information please visit our <a href="{{ route('legal.privacy') }}" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">privacy policy</a>.</p>
        </x-help-card>

        <x-help-card :title="__('Is DiscordLookup open source?')">
            <p>Yes! DiscordLookup is fully open source on <a href="{{ env('GITHUB_URL') }}" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">GitHub</a>.</p>
            <p>Feel free to give us a <a href="{{ env('GITHUB_URL') }}/stargazers" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">star on GitHub</a> if you like our work.</p>
        </x-help-card>
    </div>
</div>
