<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * @param $snowflake
 * @return float|int
 * @see https://discord.com/developers/docs/reference#convert-snowflake-to-datetime
 */
function getTimestamp($snowflake)
{
    return $snowflake / 4194304 + 1420070400000;
}

/**
 * @param $guildId
 * @param $totalShards
 * @return int
 * @see https://discord.com/developers/docs/topics/gateway#sharding-sharding-formula
 */
function getShardId($guildId, $totalShards): int
{
    return ($guildId >> 22) % $totalShards;
}

/**
 * @param $snowflake
 * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
 */
function invalidateSnowflake($snowflake)
{
    if (!validateInt($snowflake))
    {
        return __('That doesn\'t look like a valid snowflake. Snowflakes contain only numbers.');
    }
    else if ($snowflake < 4194304)
    {
        return __('That doesn\'t look like a valid snowflake. Snowflakes are much larger numbers.');
    }
    return null;
}

/**
 * @param $permissions
 * @return bool
 * @see https://discord.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags
 */
function hasAdministrator($permissions)
{
    return (($permissions & (1 << 3)) == (1 << 3));
}

/**
 * @param $permissions
 * @return bool
 * @see https://discord.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags
 */
function hasModerator($permissions)
{
    return
        (($permissions & (1 << 1)) == (1 << 1)) || // KICK_MEMBERS
        (($permissions & (1 << 2)) == (1 << 2)) || // BAN_MEMBERS
        (($permissions & (1 << 4)) == (1 << 4)) || // MANAGE_CHANNELS
        (($permissions & (1 << 5)) == (1 << 5)) || // MANAGE_GUILD
        (($permissions & (1 << 13)) == (1 << 13)) || // MANAGE_MESSAGES
        (($permissions & (1 << 27)) == (1 << 27)) || // MANAGE_NICKNAMES
        (($permissions & (1 << 28)) == (1 << 28)) || // MANAGE_ROLES
        (($permissions & (1 << 29)) == (1 << 29)) || // MANAGE_WEBHOOKS
        (($permissions & (1 << 34)) == (1 << 34)) || // MANAGE_THREADS
        (($permissions & (1 << 40)) == (1 << 40)); // MODERATE_MEMBERS
}

/**
 * @return array[]
 * @see https://discord.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags
 */
function getPermissionList(): array
{
    return [
        'CREATE_INSTANT_INVITE' => [
            'name' => 'Create Instant Invite',
            'bitwise' => (1 << 0),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'KICK_MEMBERS' => [
            'name' => 'Kick Members',
            'bitwise' => (1 << 1),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'BAN_MEMBERS' => [
            'name' => 'Ban Members',
            'bitwise' => (1 << 2),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'ADMINISTRATOR' => [
            'name' => 'Administrator',
            'bitwise' => (1 << 3),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'MANAGE_CHANNELS' => [
            'name' => 'Manage Channels',
            'bitwise' => (1 << 4),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'MANAGE_GUILD' => [
            'name' => 'Manage Server',
            'bitwise' => (1 << 5),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'ADD_REACTIONS' => [
            'name' => 'Add Reactions',
            'bitwise' => (1 << 6),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'VIEW_AUDIT_LOG' => [
            'name' => 'View Audit Log',
            'bitwise' => (1 << 7),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'PRIORITY_SPEAKER' => [
            'name' => 'Priority Speaker',
            'bitwise' => (1 << 8),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'STREAM' => [
            'name' => 'Video',
            'bitwise' => (1 << 9),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'VIEW_CHANNEL' => [
            'name' => 'Read Messages/View Channels',
            'bitwise' => (1 << 10),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'SEND_MESSAGES' => [
            'name' => 'Send Messages',
            'bitwise' => (1 << 11),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'SEND_TTS_MESSAGES' => [
            'name' => 'Send TTS Messages',
            'bitwise' => (1 << 12),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'MANAGE_MESSAGES' => [
            'name' => 'Manage Messages',
            'bitwise' => (1 << 13),
            'group' => 'text',
            'requireTwoFactor' => true,
        ],
        'EMBED_LINKS' => [
            'name' => 'Embed Links',
            'bitwise' => (1 << 14),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'ATTACH_FILES' => [
            'name' => 'Attach Files',
            'bitwise' => (1 << 15),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'READ_MESSAGE_HISTORY' => [
            'name' => 'Read Message History',
            'bitwise' => (1 << 16),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'MENTION_EVERYONE' => [
            'name' => 'Mention @everyone, @here, and All Roles',
            'bitwise' => (1 << 17),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'USE_EXTERNAL_EMOJIS' => [
            'name' => 'Use External Emojis',
            'bitwise' => (1 << 18),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'VIEW_GUILD_INSIGHTS' => [
            'name' => 'View Server Insights',
            'bitwise' => (1 << 19),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'CONNECT' => [
            'name' => 'Connect',
            'bitwise' => (1 << 20),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'SPEAK' => [
            'name' => 'Speak',
            'bitwise' => (1 << 21),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'MUTE_MEMBERS' => [
            'name' => 'Mute Members',
            'bitwise' => (1 << 22),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'DEAFEN_MEMBERS' => [
            'name' => 'Deafen Members',
            'bitwise' => (1 << 23),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'MOVE_MEMBERS' => [
            'name' => 'Move Members',
            'bitwise' => (1 << 24),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'USE_VAD' => [
            'name' => 'Use Voice Activity',
            'bitwise' => (1 << 25),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'CHANGE_NICKNAME' => [
            'name' => 'Change Nickname',
            'bitwise' => (1 << 26),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'MANAGE_NICKNAMES' => [
            'name' => 'Manage Nicknames',
            'bitwise' => (1 << 27),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'MANAGE_ROLES' => [
            'name' => 'Manage Roles',
            'bitwise' => (1 << 28),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'MANAGE_WEBHOOKS' => [
            'name' => 'Manage Webhooks',
            'bitwise' => (1 << 29),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'MANAGE_EMOJIS_AND_STICKERS' => [
            'name' => 'Manage Emojis and Stickers',
            'bitwise' => (1 << 30),
            'group' => 'general',
            'requireTwoFactor' => true,
        ],
        'USE_APPLICATION_COMMANDS' => [
            'name' => 'Use Application Commands',
            'bitwise' => (1 << 31),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'REQUEST_TO_SPEAK' => [
            'name' => 'Request To Speak',
            'bitwise' => (1 << 32),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'MANAGE_EVENTS' => [
            'name' => 'Manage Events',
            'bitwise' => (1 << 33),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'MANAGE_THREADS' => [
            'name' => 'Manage Threads',
            'bitwise' => (1 << 34),
            'group' => 'text',
            'requireTwoFactor' => true,
        ],
        'CREATE_PUBLIC_THREADS' => [
            'name' => 'Create Public Threads',
            'bitwise' => (1 << 35),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'CREATE_PRIVATE_THREADS' => [
            'name' => 'Create Private Threads',
            'bitwise' => (1 << 36),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'USE_EXTERNAL_STICKERS' => [
            'name' => 'Use External Stickers',
            'bitwise' => (1 << 37),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'SEND_MESSAGES_IN_THREADS' => [
            'name' => 'Send Messages in Threads',
            'bitwise' => (1 << 38),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'START_EMBEDDED_ACTIVITIES' => [
            'name' => 'Use Embedded Activities',
            'bitwise' => (1 << 39),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'MODERATE_MEMBERS' => [
            'name' => 'Moderate Members',
            'bitwise' => (1 << 40),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'VIEW_CREATOR_MONETIZATION_ANALYTICS' => [
            'name' => 'View Creator Monetization Insights',
            'bitwise' => (1 << 41),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'USE_SOUNDBOARD' => [
            'name' => 'Use Soundboard',
            'bitwise' => (1 << 42),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'CREATE_GUILD_EXPRESSIONS' => [
            'name' => 'Create Expressions',
            'bitwise' => (1 << 43),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'CREATE_EVENTS' => [
            'name' => 'Create Events',
            'bitwise' => (1 << 44),
            'group' => 'general',
            'requireTwoFactor' => false,
        ],
        'USE_EXTERNAL_SOUNDS' => [
            'name' => 'Use External Sounds',
            'bitwise' => (1 << 45),
            'group' => 'voice',
            'requireTwoFactor' => false,
        ],
        'SEND_VOICE_MESSAGES' => [
            'name' => 'Send Voice Message',
            'bitwise' => (1 << 46),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
    ];
}

/**
 * @param $bitwise
 * @return array
 * @see https://discord.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags
 */
function getPermissionFlagListNames($bitwise): array
{
    $permissions = getPermissionList();
    $permissionsNames = [];
    foreach ($permissions as $permission)
    {
        if (($bitwise & $permission['bitwise']) == $permission['bitwise'])
            $permissionsNames[] = $permission['name'];
    }

    return $permissionsNames;
}

/**
 * @param $bitwise
 * @return array
 * @see https://discord.com/developers/docs/resources/application#application-object-application-flags
 */
function getApplicationFlagListNames($bitwise): array
{
    $permissions = [
        'APPLICATION_AUTO_MODERATION_RULE_CREATE_BADGE' => (1 << 6),
        'GATEWAY_PRESENCE' => (1 << 12),
        'GATEWAY_PRESENCE_LIMITED' => (1 << 13),
        'GATEWAY_GUILD_MEMBERS' => (1 << 14),
        'GATEWAY_GUILD_MEMBERS_LIMITED' => (1 << 15),
        'VERIFICATION_PENDING_GUILD_LIMIT' => (1 << 16),
        'EMBEDDED' => (1 << 17),
        'GATEWAY_MESSAGE_CONTENT' => (1 << 18),
        'GATEWAY_MESSAGE_CONTENT_LIMITED' => (1 << 19),
        'APPLICATION_COMMAND_BADGE' => (1 << 23),
    ];

    $permissionsList = [];
    foreach ($permissions as $permission => $value)
    {
        if (($bitwise & $value) == $value)
            $permissionsList[] = $permission;
    }

    return $permissionsList;
}

/**
 * @param $flags
 * @return array
 * @see https://discord.com/developers/docs/resources/user#user-object-user-flags
 */
function getUserFlagList($flags)
{
    $list = [];

    if($flags & (1 << 0)) $list[] = ['name' => 'Discord Staff', 'image' => asset('images/discord/icons/badges/discord_staff.svg')];
    if($flags & (1 << 1)) $list[] = ['name' => 'Partnered Server Owner', 'image' => asset('images/discord/icons/badges/partnered_server_owner.svg')];
    if($flags & (1 << 2)) $list[] = ['name' => 'HypeSquad Events', 'image' => asset('images/discord/icons/badges/hypesquad_events.svg')];
    if($flags & (1 << 3)) $list[] = ['name' => 'Bug Hunter Level 1', 'image' => asset('images/discord/icons/badges/bug_hunter_level-1.svg')];
    if($flags & (1 << 6)) $list[] = ['name' => 'HypeSquad House Bravery', 'image' => asset('images/discord/icons/badges/hypesquad_house-bravery.svg')];
    if($flags & (1 << 7)) $list[] = ['name' => 'HypeSquad House Brilliance', 'image' => asset('images/discord/icons/badges/hypesquad_house-brilliance.svg')];
    if($flags & (1 << 8)) $list[] = ['name' => 'HypeSquad House Balance', 'image' => asset('images/discord/icons/badges/hypesquad_house-balance.svg')];
    if($flags & (1 << 9)) $list[] = ['name' => 'Early Supporter', 'image' => asset('images/discord/icons/badges/early_supporter.svg')];
    if($flags & (1 << 10)) $list[] = ['name' => 'Team User', 'image' => ''];
    if($flags & (1 << 12)) $list[] = ['name' => 'System User', 'image' => ''];
    if($flags & (1 << 14)) $list[] = ['name' => 'Bug Hunter Level 2', 'image' => asset('images/discord/icons/badges/bug_hunter_level-2.svg')];
    if($flags & (1 << 16)) $list[] = ['name' => 'Verified Bot', 'image' => asset('images/discord/icons/badges/verified_bot.svg')];
    if($flags & (1 << 17)) $list[] = ['name' => 'Early Verified Bot Developer', 'image' => asset('images/discord/icons/badges/early_verified_bot_developer.svg')];
    if($flags & (1 << 18)) $list[] = ['name' => 'Moderator Programs Alumni', 'image' => asset('images/discord/icons/badges/moderator_programs_alumni.svg')];
    if($flags & (1 << 22)) $list[] = ['name' => 'Active Developer', 'image' => asset('images/discord/icons/badges/active_developer.svg')];

    return $list;
}

/**
 * @param $premiumType
 * @return string
 * @see https://discord.com/developers/docs/resources/user#user-object-premium-types
 */
function getPremiumType($premiumType)
{
    switch ($premiumType) {
        case 0:
            return 'None';
        case 1:
            return 'Nitro Classic';
        case 2:
            return 'Nitro';
        case 3:
            return 'Nitro Basic';
        default:
            return 'Unknown (Type ' . $premiumType . ')';
    }
}

/**
 * @param $userId
 * @param $avatar
 * @param int $size
 * @param string $format
 * @param bool $allowAnimated
 * @return string Discord CDN User Avatar URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getAvatarUrl($userId, $avatar, int $size = 64, string $format = 'webp', bool $allowAnimated = true)
{
    if ($allowAnimated && str_starts_with($avatar, 'a_')) $format = 'gif';
    return env('DISCORD_CDN_URL') . "/avatars/{$userId}/{$avatar}.{$format}?size={$size}";
}

/**
 * @param $userId
 * @return string Discord CDN User Default Avatar URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getDefaultAvatarUrl($userId)
{
    return env('DISCORD_CDN_URL') . '/embed/avatars/' . (($userId >> 22) % 6) . '.png';
}

/**
 * @param $userId
 * @param $banner
 * @param int $size
 * @param string $format
 * @param bool $allowAnimated
 * @return string Discord CDN User Banner URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getGuildBannerUrl($userId, $banner, int $size = 64, string $format = 'webp', bool $allowAnimated = true)
{
    if ($allowAnimated && str_starts_with($banner, 'a_')) $format = 'gif';
    return env('DISCORD_CDN_URL') . "/banners/{$userId}/{$banner}.{$format}?size={$size}";
}

/**
 * @param $scheduledEventId
 * @param $image
 * @param int $size
 * @param string $format
 * @return string Discord CDN Guild Scheduled Event Cover URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getGuildScheduledEventCoverUrl($scheduledEventId, $image, int $size = 64, string $format = 'webp')
{
    return env('DISCORD_CDN_URL') . "/guild-events/{$scheduledEventId}/{$image}.{$format}?size={$size}";
}

/**
 * @param $emojiId
 * @param int $size
 * @param string $format
 * @param bool $animated
 * @return string Discord CDN Emoji URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getCustomEmojiUrl($emojiId, int $size = 64, string $format = 'webp', bool $animated = true)
{
    if ($animated) $format = 'gif';
    return env('DISCORD_CDN_URL') . "/emojis/{$emojiId}.{$format}?size={$size}";
}

/**
 * @param $stickerId
 * @param int $size
 * @param string $format
 * @return string Discord CDN Sticker URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getStickerUrl($stickerId, int $size = 128, string $format = 'png')
{
    return env('DISCORD_CDN_URL') . "/stickers/{$stickerId}.{$format}?size={$size}";
}

/**
 * @param $name
 * @param $title
 * @return string
 */
function getDiscordBadgeServerIcons($name, $title)
{
    return "<img src=\"" . asset('images/discord/icons/server/' . $name . '.svg') . "\" class=\"inline-block h-4 w-4 mb-1 mr-px\" alt=\"{$name} badge\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$title}\">";
}


function getDiscordBadgeServerBoosts($boostLevel)
{
    return "<img src=\"" . asset('images/discord/icons/boosts/boost-' . $boostLevel . '.svg') . "\" class=\"inline-block h-4 w-4 mb-0.5 mr-px\" alt=\"Boost Level {$boostLevel}\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Boost Level {$boostLevel}\">";
}

/**
 * @param $userId
 * @return array|null
 */
function getUser($userId)
{
    $array = [
        'id' => '',
        'username' => '',
        'discriminator' => '',
        'global_name' => '',
        'avatarUrl' => '',
        'avatarDecorationUrl' => '',
        'bannerUrl' => '',
        'bannerColor' => '',
        'accentColor' => '',
        'flags' => '',
        'flagsList' => [],
        'isBot' => '',
        'isVerifiedBot' => '',
    ];

    if(Cache::has('user:' . $userId))
    {
        $responseJson = Cache::get('user:' . $userId);
    }
    else
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
        ])->get(env('DISCORD_API_URL') . '/users/' . $userId);

        if(!$response->ok())
            return null;

        $responseJson = $response->json();
        Cache::put('user:' . $userId, $responseJson, 900); // 15 minutes
    }

    if ($responseJson == null || !key_exists('id', $responseJson))
        return null;

    if (key_exists('id', $responseJson))
        $array['id'] = $responseJson['id'];

    if (key_exists('username', $responseJson))
        $array['username'] = $responseJson['username'];

    if (key_exists('discriminator', $responseJson))
        $array['discriminator'] = $responseJson['discriminator'];

    if (key_exists('global_name', $responseJson))
        $array['global_name'] = $responseJson['global_name'];

    if (key_exists('bot', $responseJson))
        $array['isBot'] = $responseJson['bot'];

    if (key_exists('avatar', $responseJson) && $responseJson['avatar'] != null)
        $array['avatarUrl'] = getAvatarUrl($responseJson['id'], $responseJson['avatar'], 512, 'webp', true);

    if (empty($array['avatarUrl']))
        $array['avatarUrl'] = getDefaultAvatarUrl($responseJson['id']);

    // TODO: Add custom avatar decorations once released and documented by Discord
    if (key_exists('avatar_decoration_data', $responseJson) && $responseJson['avatar_decoration_data'] != null && key_exists('asset', $responseJson['avatar_decoration_data']) && $responseJson['avatar_decoration_data']['asset'] != null)
        $array['avatarDecorationUrl'] = env('DISCORD_CDN_URL') . '/avatar-decoration-presets/' . $responseJson['avatar_decoration_data']['asset'] . '?size=512';

    if (key_exists('banner', $responseJson) && $responseJson['banner'] != null)
        $array['bannerUrl'] = getGuildBannerUrl($responseJson['id'], $responseJson['banner'], 512, 'webp', true);

    if (key_exists('banner_color', $responseJson) && $responseJson['banner_color'] != null)
        $array['bannerColor'] = $responseJson['banner_color'];

    if (key_exists('accent_color', $responseJson) && $responseJson['accent_color'] != null)
        $array['accentColor'] = '#' . dechex($responseJson['accent_color']);

    if (key_exists('public_flags', $responseJson))
    {
        $array['flags'] = $responseJson['public_flags'];
        $array['flagsList'] = getUserFlagList($array['flags']);
        if ($array['flags'] & (1 << 16))
            $array['isVerifiedBot']  = true;
    }

    return $array;
}

/**
 * @param $guildId
 * @return array|null
 */
function getGuildWidget($guildId)
{
    $array = [
        'id' => '',
        'name' => '',
        'instantInviteUrlCode' => '',
        'instantInviteUrl' => '',
        'channels' => [],
        'members' => [],
        'onlineCount' => '',
    ];

    if(Cache::has('guildWidget:' . $guildId))
    {
        $responseJson = Cache::get('guildWidget:' . $guildId);
    }
    else
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
        ])->get(env('DISCORD_API_URL') . '/guilds/' . $guildId . '/widget.json');

        if(!$response->ok())
            return null;

        $responseJson = $response->json();
        Cache::put('guildWidget:' . $guildId, $responseJson, 900); // 15 minutes
    }

    if ($responseJson == null || !key_exists('id', $responseJson))
        return null;

    $array['id'] = $responseJson['id'];

    if(array_key_exists('name', $responseJson))
        $array['name'] = $responseJson['name'];

    if(array_key_exists('instant_invite', $responseJson))
    {
        $array['instantInviteUrlCode'] = str_replace('https://discord.com/invite/', '', $responseJson['instant_invite']);
        $array['instantInviteUrl'] = empty($array['instantInviteUrlCode']) ? '' : env('DISCORD_INVITE_PREFIX') . $array['instantInviteUrlCode'];
    }

    if(array_key_exists('presence_count', $responseJson))
        $array['onlineCount'] = $responseJson['presence_count'];

    if(array_key_exists('channels', $responseJson))
        $array['channels'] = $responseJson['channels'];

    if(array_key_exists('members', $responseJson))
        $array['members'] = $responseJson['members'];

    return $array;
}

/**
 * @param $guildId
 * @return array|null
 */
function getGuildPreview($guildId)
{
    $array = [
        'id' => '',
        'name' => '',
        'description' => '',
        'iconUrl' => env('DISCORD_CDN_URL') . '/embed/avatars/0.png',
        'splashUrl' => '',
        'discoverySplashUrl' => '',
        'features' => [],
        'isPartnered' => false,
        'isVerified' => false,
        'memberCount' => 0,
        'onlineCount' => 0,
        'emojis' => '',
        'stickers' => '',
    ];

    if(Cache::has('guildPreview:' . $guildId))
    {
        $responseJson = Cache::get('guildPreview:' . $guildId);
    }
    else
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
        ])->get(env('DISCORD_API_URL') . '/guilds/' . $guildId . '/preview');

        if(!$response->ok())
            return null;

        $responseJson = $response->json();
        Cache::put('guildPreview:' . $guildId, $responseJson, 900); // 15 minutes
    }

    if ($responseJson == null || !key_exists('id', $responseJson))
        return null;

    if(array_key_exists('name', $responseJson))
        $array['name'] = $responseJson['name'];

    if(array_key_exists('description', $responseJson))
        $array['description'] = $responseJson['description'];

    if(array_key_exists('approximate_member_count', $responseJson))
        $array['memberCount'] = $responseJson['approximate_member_count'];

    if(array_key_exists('approximate_presence_count', $responseJson))
        $array['onlineCount'] = $responseJson['approximate_presence_count'];

    if(array_key_exists('emojis', $responseJson))
        $array['emojis'] = $responseJson['emojis'];

    if(array_key_exists('stickers', $responseJson))
        $array['stickers'] = $responseJson['stickers'];

    if($responseJson['icon'] != null)
        $array['iconUrl'] = env('DISCORD_CDN_URL') . '/icons/' . $responseJson['id'] . '/' . $responseJson['icon'] . '?size=128';

    if(array_key_exists('splash', $responseJson) && $responseJson['splash'] != null)
        $array['splashUrl'] = env('DISCORD_CDN_URL') . '/splashes/' . $array['id'] . '/' . $responseJson['splash'];

    if(array_key_exists('discovery_splash', $responseJson) && $responseJson['discovery_splash'] != null)
        $array['discoverySplashUrl'] = env('DISCORD_CDN_URL') . '/discovery-splashes/' . $array['id'] . '/' . $responseJson['discovery_splash'];

    foreach ($responseJson['features'] as $feature)
    {
        if($feature == 'PARTNERED')
            $array['isPartnered'] = true;
        if($feature == 'VERIFIED')
            $array['isVerified'] = true;

        $array['features'][] .= strtolower(str_replace('_', ' ', $feature));
    }
    sort($array['features']);

    return $array;
}

/**
 * @param $json
 * @return array|null
 */
function parseInviteJson($json)
{
    $array = [
        'hasEvent' => false,
        'type' => 0,
        'typeName' => '',
        'expiresAt' => '',
        'expiresAtFormatted' => '&infin;',
        'guild' => [
            'id' => '',
            'name' => '',
            'description' => '',
            'iconUrl' => env('DISCORD_CDN_URL') . '/embed/avatars/0.png',
            'bannerUrl' => '',
            'features' => [],
            'isPartnered' => false,
            'isVerified' => false,
            'isNSFW' => false,
            'isNSFWLevel' => 0,
            'vanityUrlCode' => '',
            'vanityUrl' => '',
            'memberCount' => 0,
            'onlineCount' => 0,
            'boostCount' => 0,
            'boostLevel' => 0,
        ],
        'inviter' => [
            'id' => '',
            'username' => '',
            'discriminator' => '',
            'global_name' => '',
            'avatarUrl' => '',
            'avatarDecorationUrl' => '',
            'bannerUrl' => '',
            'bannerColor' => '',
            'accentColor' => '',
            'premiumType' => 0,
            'premiumTypeName' => '',
            'flags' => '',
            'flagsList' => [],
            'isBot' => false,
            'isVerifiedBot' => false,
        ],
        'channel' => [
            'id' => '',
            'name' => '',
            'icon' => '',
            'iconUrl' => '',
            'recipients' => [],
        ],
        'event' => [
            'id' => '',
            'channelId' => '',
            'creatorId' => '',
            'name' => '',
            'description' => '',
            'image' => '',
            'startTime' => '',
            'startTimeFormatted' => '',
            'endTime' => '',
            'endTimeFormatted' => '',
            'privacyLevel' => 2,
            'status' => 1,
            'entityType' => '',
            'entityId' => '',
            'entityMetadataLocation' => '',
            'userCount' => 0,
        ],
    ];

    if($json == null)
        return null;

    $array['type'] = $json['type'];
    switch ($json['type'])
    {
        case 0:
            $array['typeName'] = 'Guild';
            break;
        case 1:
            $array['typeName'] = 'Group DM';
            break;
        case 2:
            $array['typeName'] = 'Friend';
            break;
        default:
            $array['typeName'] = $json['type'];
            break;
    }

    /* Guild */
    if(array_key_exists('guild', $json) && $json['guild'] != null)
    {
        $array['guild']['id'] = $json['guild']['id'];
        $array['guild']['name'] = $json['guild']['name'];
        $array['guild']['description'] = $json['guild']['description'];
        $array['guild']['isNSFW'] = $json['guild']['nsfw'];
        $array['guild']['isNSFWLevel'] = $json['guild']['nsfw_level'];
        $array['guild']['boostCount'] = $json['guild']['premium_subscription_count'];

        $boosts = $array['guild']['boostCount'];
        if ($boosts >= 14) {
            $array['guild']['boostLevel'] = 3;
        }else if ($boosts >= 7) {
            $array['guild']['boostLevel'] = 2;
        }else if ($boosts >= 2) {
            $array['guild']['boostLevel'] = 1;
        }else{
            $array['guild']['boostLevel'] = 0;
        }

        if($json['guild']['icon'] != null)
            $array['guild']['iconUrl'] = env('DISCORD_CDN_URL') . '/icons/' . $array['guild']['id'] . '/' . $json['guild']['icon'] . '?size=128';

        if(array_key_exists('banner', $json['guild']) && $json['guild']['banner'] != null)
            $array['guild']['bannerUrl'] = getGuildBannerUrl($array['guild']['id'], $json['guild']['banner'], 512, 'webp', true);

        if(array_key_exists('vanity_url_code', $json['guild']))
        {
            $array['guild']['vanityUrlCode'] = $json['guild']['vanity_url_code'];
            $array['guild']['vanityUrl'] = empty($array['guild']['vanityUrlCode']) ? '' : env('DISCORD_INVITE_PREFIX') . $array['guild']['vanityUrlCode'];
        }

        foreach ($json['guild']['features'] as $feature)
        {
            if($feature == 'PARTNERED')
                $array['guild']['isPartnered'] = true;
            if($feature == 'VERIFIED')
                $array['guild']['isVerified'] = true;

            $array['guild']['features'][] .= strtolower(str_replace('_', ' ', $feature));
        }
        sort($array['guild']['features']);
    }

    if(array_key_exists('approximate_member_count', $json))
        $array['guild']['memberCount'] = $json['approximate_member_count'];

    if(array_key_exists('approximate_presence_count', $json))
        $array['guild']['onlineCount'] = $json['approximate_presence_count'];

    /* Invite */
    if(array_key_exists('channel', $json) && $json['channel'] != null)
    {
        if(array_key_exists('id', $json['channel']))
            $array['channel']['id'] = $json['channel']['id'];
        if(array_key_exists('name', $json['channel']))
            $array['channel']['name'] = $json['channel']['name'];
        if(array_key_exists('icon', $json['channel'])) {
            $array['channel']['icon'] = $json['channel']['icon'];
            $array['channel']['iconUrl'] = env('DISCORD_CDN_URL') . '/channel-icons/' . $array['channel']['id'] . '/' . $array['channel']['icon'] . '?size=128';
        }
        if(array_key_exists('recipients', $json['channel']))
            $array['channel']['recipients'] = $json['channel']['recipients'];
    }

    if(array_key_exists('inviter', $json) && $json['inviter'] != null)
    {
        if (key_exists('id', $json['inviter']))
            $array['inviter']['id'] = $json['inviter']['id'];

        if (key_exists('username', $json['inviter']))
            $array['inviter']['username'] = $json['inviter']['username'];

        if (key_exists('discriminator', $json['inviter']))
            $array['inviter']['discriminator'] = $json['inviter']['discriminator'];

        if (key_exists('global_name', $json['inviter']))
            $array['inviter']['global_name'] = $json['inviter']['global_name'];

        if (key_exists('bot', $json['inviter']))
            $array['inviter']['isBot'] = $json['inviter']['bot'];

        if (key_exists('avatar', $json['inviter']) && $json['inviter']['avatar'] != null)
            $array['inviter']['avatarUrl'] = getAvatarUrl($json['inviter']['id'], $json['inviter']['avatar'], 512, 'webp', true);

        if (empty($array['inviter']['avatarUrl']))
            $array['inviter']['avatarUrl'] = getDefaultAvatarUrl($json['inviter']['id']);

        // TODO: Add custom avatar decorations once released and documented by Discord
        if (key_exists('avatar_decoration_data', $json['inviter']) && $json['inviter']['avatar_decoration_data'] != null && key_exists('asset', $json['inviter']['avatar_decoration_data']) && $json['inviter']['avatar_decoration_data']['asset'] != null)
            $array['inviter']['avatarDecorationUrl'] = env('DISCORD_CDN_URL') . '/avatar-decoration-presets/' . $json['inviter']['avatar_decoration_data']['asset'] . '?size=512';

        if (key_exists('banner', $json['inviter']) && $json['inviter']['banner'] != null)
            $array['inviter']['bannerUrl'] = getGuildBannerUrl($json['inviter']['id'], $json['inviter']['banner'], 512, 'webp', true);

        if (key_exists('banner_color', $json['inviter']) && $json['inviter']['banner_color'] != null)
            $array['inviter']['bannerColor'] = $json['inviter']['banner_color'];

        if (key_exists('accent_color', $json['inviter']) && $json['inviter']['accent_color'] != null)
            $array['inviter']['accentColor'] = '#' . dechex($json['inviter']['accent_color']);

        if (key_exists('premium_type', $json['inviter']) && $json['inviter']['premium_type'] != null) {
            $array['inviter']['premiumType'] = $json['inviter']['premium_type'];
            $array['inviter']['premiumTypeName'] = getPremiumType($json['inviter']['premium_type']);
        }

        if (key_exists('public_flags', $json['inviter']))
        {
            $array['inviter']['flags'] = $json['inviter']['public_flags'];
            $array['inviter']['flagsList'] = getUserFlagList($array['inviter']['flags']);
            if ($array['inviter']['flags'] & (1 << 16))
                $array['inviter']['isVerifiedBot']  = true;
        }
    }

    if(array_key_exists('expires_at', $json) && $json['expires_at'] != null)
    {
        $array['expiresAt'] = $json['expires_at'];
        $array['expiresAtFormatted'] = date('Y-m-d G:i:s \(T\)', strtotime($array['expiresAt']));
    }

    /* Event */
    if(array_key_exists('guild_scheduled_event', $json) && $json['guild_scheduled_event'] != null)
    {
        $array['hasEvent'] = true;

        $array['event']['id'] = $json['guild_scheduled_event']['id'];
        $array['event']['channelId'] = $json['guild_scheduled_event']['channel_id'];
        $array['event']['creatorId'] = $json['guild_scheduled_event']['creator_id'];
        $array['event']['name'] = $json['guild_scheduled_event']['name'];
        $array['event']['description'] = $json['guild_scheduled_event']['description'];
        $array['event']['image'] = $json['guild_scheduled_event']['image'];
        $array['event']['startTime'] = $json['guild_scheduled_event']['scheduled_start_time'];
        $array['event']['endTime'] = $json['guild_scheduled_event']['scheduled_end_time'];
        $array['event']['entityId'] = $json['guild_scheduled_event']['entity_id'];
        $array['event']['userCount'] = $json['guild_scheduled_event']['user_count'];

        if($array['event']['image'] != null)
            $array['event']['imageUrl'] = getGuildScheduledEventCoverUrl($array['event']['id'], $array['event']['image'], 512, 'webp');

        if($array['event']['startTime'])
            $array['event']['startTimeFormatted'] = date('Y-m-d G:i:s \(T\)', strtotime($array['event']['startTime']));

        if($array['event']['endTime'])
            $array['event']['endTimeFormatted'] = date('Y-m-d G:i:s \(T\)', strtotime($array['event']['endTime']));

        switch ($json['guild_scheduled_event']['privacy_level'])
        {
            case 2:
                $array['event']['privacyLevel'] = 'GUILD_ONLY';
                break;
            default:
                $array['event']['privacyLevel'] = $json['guild_scheduled_event']['privacy_level'];
                break;
        }

        switch ($json['guild_scheduled_event']['status'])
        {
            case 1:
                $array['event']['status'] = 'SCHEDULED';
                break;
            case 2:
                $array['event']['status'] = 'ACTIVE';
                break;
            case 3:
                $array['event']['status'] = 'COMPLETED';
                break;
            case 4:
                $array['event']['status'] = 'CANCELED';
                break;
            default:
                $array['event']['status'] = $json['guild_scheduled_event']['status'];
                break;
        }

        switch ($json['guild_scheduled_event']['entity_type'])
        {
            case 1:
                $array['event']['entityType'] = 'STAGE_INSTANCE';
                break;
            case 2:
                $array['event']['entityType'] = 'VOICE';
                break;
            case 3:
                $array['event']['entityType'] = 'EXTERNAL';
                break;
            default:
                $array['event']['entityType'] = $json['guild_scheduled_event']['entity_type'];
                break;
        }

        if(array_key_exists('entity_metadata', $json['guild_scheduled_event']))
        {
            if($json['guild_scheduled_event']['entity_metadata'] != null && array_key_exists('location', $json['guild_scheduled_event']['entity_metadata']))
                $array['event']['entityMetadataLocation'] = $json['guild_scheduled_event']['entity_metadata']['location'];

            // TODO: Speaker IDs
        }
    }

    return $array;
}

function getApplicationRpc($applicationId)
{
    $array = [
        'id' => '',
        'name' => '',
        'description' => '',
        'descriptionFormatted' => '',
        'type' => '',
        'iconUrl' => env('DISCORD_CDN_URL') . '/embed/avatars/0.png',
        'coverImageUrl' => '',
        'hook' => '',
        'guildId' => '',
        'botPublic' => '',
        'botRequireCodeGrant' => '',
        'termsOfServiceUrl' => '',
        'privacyPolicyUrl' => '',
        'customInstallUrl' => '',
        'roleConnectionsVerificationUrl' => '',
        'verifyKey' => '',
        'flags' => '',
        'flagsList' => [],
        'tags' => [],
    ];

    if(Cache::has('applicationRpc:' . $applicationId))
    {
        $responseJson = Cache::get('applicationRpc:' . $applicationId);
    }
    else
    {
        $response = Http::get(env('DISCORD_API_URL') . '/applications/' . $applicationId . '/rpc');

        if(!$response->ok())
            return null;

        $responseJson = $response->json();
        Cache::put('applicationRpc:' . $applicationId, $responseJson, 900); // 15 minutes
    }

    if ($responseJson == null || !key_exists('id', $responseJson))
        return null;

    $array['id'] = $responseJson['id'];

    if(array_key_exists('name', $responseJson))
        $array['name'] = $responseJson['name'];

    if(array_key_exists('description', $responseJson))
    {
        $array['description'] = $responseJson['description'];
        // No Markdown parse for security reasons (show images, ...)
        // TODO: Only Discord Markdown (Bold, Italic, Underline)
        //$array['descriptionFormatted'] = \Illuminate\Mail\Markdown::parse(str_replace("\n", "<br>", $array['description']));
        $array['descriptionFormatted'] = str_replace("\n", "<br>", $array['description']);
    }

    if(array_key_exists('type', $responseJson))
        $array['type'] = $responseJson['type'];

    if (key_exists('icon', $responseJson) && $responseJson['icon'] != null)
        $array['iconUrl'] = env('DISCORD_CDN_URL') . '/app-icons/' . $responseJson['id'] . '/' . $responseJson['icon'] . '?size=512';

    if (key_exists('cover_image', $responseJson) && $responseJson['cover_image'] != null)
        $array['coverImageUrl'] = env('DISCORD_CDN_URL') . '/app-icons/' . $responseJson['id'] . '/' . $responseJson['cover_image'] . '?size=512';

    if(array_key_exists('hook', $responseJson))
        $array['hook'] = $responseJson['hook'];

    if(array_key_exists('guild_id', $responseJson))
        $array['guildId'] = $responseJson['guild_id'];

    if(array_key_exists('bot_public', $responseJson))
        $array['botPublic'] = $responseJson['bot_public'];

    if(array_key_exists('bot_require_code_grant', $responseJson))
        $array['botRequireCodeGrant'] = $responseJson['bot_require_code_grant'];

    if(array_key_exists('terms_of_service_url', $responseJson))
        $array['termsOfServiceUrl'] = $responseJson['terms_of_service_url'];

    if(array_key_exists('privacy_policy_url', $responseJson))
        $array['privacyPolicyUrl'] = $responseJson['privacy_policy_url'];

    if(array_key_exists('custom_install_url', $responseJson))
        $array['customInstallUrl'] = $responseJson['custom_install_url'];

    if(array_key_exists('role_connections_verification_url', $responseJson))
        $array['roleConnectionsVerificationUrl'] = $responseJson['role_connections_verification_url'];

    if(array_key_exists('verify_key', $responseJson))
        $array['verifyKey'] = $responseJson['verify_key'];

    if (key_exists('flags', $responseJson))
    {
        $array['flags'] = $responseJson['flags'];
        $array['flagsList'] = getApplicationFlagListNames($array['flags']);
    }

    if(array_key_exists('tags', $responseJson))
        $array['tags'] = $responseJson['tags'];

    return $array;
}
