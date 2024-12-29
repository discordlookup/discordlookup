<?php

return [
    'client_id' => env('DISCORD_CLIENT_ID', '892399371910524938'),
    'client_secret' => env('DISCORD_CLIENT_SECRET', ''),
    'bot_token' => env('DISCORD_BOT_TOKEN', ''),
    'redirect_uri' => env('DISCORD_REDIRECT_URI', 'http://localhost/auth/callback'),
    'guild_id' => env('DISCORD_GUILD_ID', '980791496833908778'),
    'api_url' => env('DISCORD_API_URL', 'https://discord.com/api/v10'),
    'cdn_url' => env('DISCORD_CDN_URL', 'https://cdn.discordapp.com'),
    'invite_url' => env('DISCORD_INVITE_URL'),
    'invite_prefix' => env('DISCORD_INVITE_PREFIX', 'https://discord.gg/'),
    'experiments_worker' => env('DISCORD_EXPERIMENTS_WORKER', 'https://experiments.workers.discordlookup.com'),
];
