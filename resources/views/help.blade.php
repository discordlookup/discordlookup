@section('title', __('Help'))
@section('description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
@section('keywords', 'help, faq, frequently asked questions, questions, support')
@section('robots', 'index, follow')

<div id="help">
    <h1 class="mb-2 mt-5 text-center text-white">{{ __('DiscordLookup Help') }}</h1>
    <div class="mb-4 text-center">
        <a role="button" href="{{ env('DISCORD_URL') }}" target="_blank" class="btn btn-primary"><i class="fab fa-discord"></i> {{ __('Support Discord') }}</a>
    </div>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="card text-white bg-dark border-0">
                    <div class="card-body">
                        <div id="what-is-a-snowflake-and-how-do-i-find-one">
                            <h2 class="h4">{{ __('What is a Snowflake and how do I find one?') }} <a href="#what-is-a-snowflake-and-how-do-i-find-one" class="text-decoration-none">#</a></h2>
                            <p>
                                A Snowflake is essentially a unique ID for a Discord resource which contains a timestamp.<br>
                                Each guild, user, channel, message, emoji and role has its own unique Snowflake ID.<br>
                                You can use the Snowflake ID to search for users and guilds or just show the creation date.<br>
                                <br>
                                To find out an ID from a Guild/User/Message, do the following:
                            <ol>
                                <li>Make sure you have enabled Discord Developer mode:
                                    <ul>
                                        <li><b>Desktop:</b> Go to <code>User Settings</code> => <code>Advanced</code> and enable <code>Developer Mode</code></li>
                                        <li><b>Mobile:</b> Go to <code>User Settings</code> => <code>Behavior</code> and enable <code>Developer Mode</code></li>
                                    </ul>
                                </li>
                                <li>Go to a guild/member/message and right click <i>(mobile long click)</i> on it</li>
                                <li>Now you can click <code>Copy ID</code> at the bottom and you have successfully copied the Snowflake ID.</li>
                            </ol>
                            <i>You can also find a video tutorial on YouTube: <a href="https://youtu.be/404AT9WeBZM?t=50" target="_blank" rel="noopener" class="text-decoration-none">https://youtu.be/404AT9WeBZM?t=50</a></i><br>
                            <i>If you want to learn more about Snowflakes visit the <a href="https://discord.com/developers/docs/reference#snowflakes" class="text-decoration-none">Discord Developer Documentation</a>.</i>
                            </p>
                        </div>
                        <hr>
                        <div id="why-some-guilds-cant-be-found-by-their-id">
                            <h2 class="h4">{{ __('Why some guilds can\'t be found by their ID/Snowflake?') }} <a href="#why-some-guilds-cant-be-found-by-their-id" class="text-decoration-none">#</a></h2>
                            <p>
                                Guild information can only be displayed if that Guild has the widget and/or Discovery enabled.<br>
                                Because the widget is off by default, many guilds cannot be loaded.<br>
                                Guilds with more than 1,000 members usually have Discovery enabled and can be loaded without problems.<br>
                                <br>
                                To enable the server widget, go to <code>Server Settings</code> => <code>Widget</code> => <code>Enable Server Widget</code> <b>and</b> select a channel under <code>Invite Channel</code>.
                            </p>
                        </div>
                        <hr>
                        <div id="how-are-my-personal-stats-calculated-in-the-guild-list">
                            <h2 class="h4">{{ __('How are my personal stats calculated in the Guild List?') }} <a href="#how-are-my-personal-stats-calculated-in-the-guild-list" class="text-decoration-none">#</a></h2>
                            <p>
                                <img src="{{ asset('images/discord/icons/server/owner.svg') }}" class="discord-badge" alt="owner badge"> <b>{{ __('You own') }}:</b> Here are servers listed that you own completely (owner)<br>
                                <img src="{{ asset('images/discord/icons/server/administrator.svg') }}" class="discord-badge" alt="administrator badge"> <b>{{ __('You administrate') }}:</b> Here are listed servers on which you have the <code>ADMINISTRATOR</code> permission<br>
                                <img src="{{ asset('images/discord/icons/server/moderator.svg') }}" class="discord-badge" alt="moderator badge"> <b>{{ __('You moderate') }}:</b> Here are listed servers on which you have at least one of the following permissions:
                                <code>KICK_MEMBERS</code>, <code>BAN_MEMBERS</code>, <code>MANAGE_CHANNELS</code>, <code>MANAGE_GUILD</code>, <code>MANAGE_MESSAGES</code>, <code>MANAGE_NICKNAMES</code>, <code>MANAGE_ROLES</code>, <code>MANAGE_WEBHOOKS</code>, <code>MANAGE_THREADS</code><br>
                                <br>
                                If a guild is already counted in a higher category, it will not be counted again.<br>
                                For example, guilds on which you have <code>ADMINISTRATOR</code> and <code>MANAGE_MESSAGES</code> permissions only count towards "You administrate".
                            </p>
                        </div>
                        <hr>
                        <div id="i-need-support-or-have-bugs-feature-requests">
                            <h2 class="h4">{{ __('I need support or have bugs/feature requests') }} <a href="#i-need-support-or-have-bugs-feature-requests" class="text-decoration-none">#</a></h2>
                            <p>
                                Visit our <a href="{{ env('DISCORD_URL') }}" target="_blank" class="text-decoration-none">Discord server</a>. We will be happy to help you there as soon as possible.
                            </p>
                        </div>
                        <hr>
                        <div id="what-happens-to-my-data-when-i-login-with-discord">
                            <h2 class="h4">{{ __('What happens to my data when I login with Discord?') }} <a href="#what-happens-to-my-data-when-i-login-with-discord" class="text-decoration-none">#</a></h2>
                            <p>
                                When you log in, Discord sends your full username, avatar and banner, as well as a list of guilds you are on at the time of login.<br>
                                We do not receive your email address or other data from Discord.<br>
                                The list of your guilds is not stored by us and is only associated with your current session. As soon as you log out or close your browser, this list is automatically deleted.<br>
                                For more information please visit our <a href="{{ route('legal.privacy') }}" class="text-decoration-none">privacy policy</a>.
                            </p>
                        </div>
                        <hr>
                        <div id="is-discordlookup-open-source">
                            <h2 class="h4">{{ __('Is DiscordLookup open source?') }} <a href="#is-discordlookup-open-source" class="text-decoration-none">#</a></h2>
                            <p>
                                Yes! DiscordLookup is fully open source on <a href="{{ env('GITHUB_URL') }}" target="_blank">GitHub</a>.<br>
                                Feel free to give us a star on <a href="{{ env('GITHUB_URL') }}/stargazers" target="_blank">GitHub</a> if you like our work.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
