@section('title', __('Home'))
@section('description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
@section('keywords', '')
@section('robots', 'index, follow')

<div>
    <div class="flex flex-col items-center justify-center space-y-1 py-16">
        <img src="{{ asset('images/branding/logo-light.svg') }}" alt="{{ env('APP_NAME') }} Logo" />
        <p class="text-xl font-bold text-center">{{ __('Get more out of Discord with Discord Lookup') }}</p>
    </div>

    <div class="space-y-4">
        <x-link-card url="{{ route('snowflake') }}" icon="far fa-snowflake" title="{{ __('Snowflake Decoder') }}" description="{{ __('Get the creation date of a Snowflake, and detailed information about Discord users and guilds.') }}" />
        <x-link-card url="{{ route('userlookup') }}" icon="fas fa-user" title="{{ __('User Lookup') }}" description="{{ __('Get detailed information about Discord users with creation date, profile picture, banner and badges.') }}" />
        <x-link-card url="{{ route('guildlookup') }}" icon="fas fa-users" title="{{ __('Guild Lookup') }}" description="{{ __('Get detailed information about Discord guilds with creation date, Invite/Vanity URL, features and emojis.') }}" />
        <x-link-card url="{{ route('applicationlookup') }}" icon="fas fa-puzzle-piece" title="{{ __('Application Lookup') }}" description="{{ __('Get detailed information about Discord applications with description, links, tags and flags.') }}" />
        <x-link-card url="{{ route('guildlist') }}" icon="fab fa-discord" title="{{ __('Guild List') }}" description="{{ __('Get detailed information about Discord applications with description, links, tags and flags.') }}" />
        <x-link-card url="{{ route('experiments.index') }}" icon="fas fa-flask" title="{{ __('Discord Experiments') }}" description="{{ __('All Discord Client & Guild Experiments with Rollout Status and detailed information about Treatments, Groups and Overrides.') }}" />
        <x-link-card url="{{ route('inviteresolver') }}" icon="fas fa-link" title="{{ __('Invite Resolver') }}" description="{{ __('Get detailed information about every invite and vanity url including event information.') }}" />
        <x-link-card url="{{ route('timestamp') }}" icon="far fa-clock" title="{{ __('Timestamp Styles') }}" description="{{ __('Generate Discord timestamp styles based on a date, time, snowflake or timestamp.') }}" />
        <x-link-card url="{{ route('permissions-calculator') }}" icon="fas fa-sort-numeric-down" title="{{ __('Permissions Calculator') }}" description="{{ __('Calculate Discord permissions integer based on the required bot permissions.') }}" />
        <x-link-card url="{{ route('snowflake-distance-calculator') }}" icon="fas fa-arrows-alt-h" title="{{ __('Snowflake Distance Calculator') }}" description="{{ __('Calculate the distance between two Discord Snowflakes.') }}" />
        <x-link-card url="{{ route('guild-shard-calculator') }}" icon="fas fa-server" title="{{ __('Guild Shard Calculator') }}" description="{{ __('Calculate the Shard ID of a guild using the Guild ID and the total number of shards.') }}" />
        <x-link-card url="{{ route('webhook-invalidator') }}" icon="fas fa-link" title="{{ __('Discord Webhook Invalidator') }}" description="{{ __('Immediately delete a Discord webhook to eliminate evil webhooks.') }}" />
        <x-link-card url="{{ env('GITHUB_URL') }}" icon="fab fa-github" title="{{ __('GitHub') }}" description="{{ __('DiscordLookup.com is fully open source on GitHub! Feel free to give us a star.') }}" />
    </div>
</div>
