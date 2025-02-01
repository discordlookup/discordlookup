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
    if (invalidateSnowflake($snowflake)) return null;
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
        'SEND_POLLS' => [
            'name' => 'Send Polls',
            'bitwise' => (1 << 49),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
        'USE_EXTERNAL_APPS' => [
            'name' => 'Use External Applications',
            'bitwise' => (1 << 50),
            'group' => 'text',
            'requireTwoFactor' => false,
        ],
    ];
}

/**
 * @return string[]
 *
 * @source https://raw.githubusercontent.com/Delitefully/DiscordLists/refs/heads/master/domains.md
 */
function getOfficialDiscordDomains(): array
{
    return [
        'dis.gd',
        'discord.co',
        'discord.com',
        'discord.design',
        'discord.dev',
        'discord.gg',
        'discord.gift',
        'discord.gifts',
        'discord.media',
        'discord.new',
        'discord.store',
        'discord.tools',
        'discordapp.com',
        'discordapp.net',
        'discordmerch.com',
        'discordpartygames.com',
        'discord-activities.com',
        'discordactivities.com',
        'discordsays.com',
        'discordsez.com',
        'discordstatus.com',
        'airhorn.solutions',
        'airhornbot.com',
        'bigbeans.solutions',
        'daveprotocol.com',
        'watchanimeattheoffice.com',
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
 * @param $userAvatar
 * @param int $size
 * @param string $format
 * @param bool $allowAnimated
 * @return string Discord CDN User Avatar URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getUserAvatarUrl($userId, $userAvatar, int $size = 64, string $format = 'webp', bool $allowAnimated = true)
{
    if ($allowAnimated && str_starts_with($userAvatar, 'a_')) $format = 'gif';
    return config('discord.cdn_url') . "/avatars/{$userId}/{$userAvatar}.{$format}?size={$size}";
}

/**
 * @param $userId
 * @return string Discord CDN User Default Avatar URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getDefaultUserAvatarUrl($userId = null)
{
    return config('discord.cdn_url') . '/embed/avatars/' . ($userId ? (($userId >> 22) % 6) : '0') . '.png';
}

/**
 * @param $guildId
 * @param $guildIcon
 * @param int $size
 * @param string $format
 * @return string Discord CDN Guild Icon URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getGuildIconUrl($guildId, $guildIcon, int $size = 128, string $format = 'webp')
{
    return config('discord.cdn_url') . "/icons/{$guildId}/{$guildIcon}.{$format}?size={$size}";
}

/**
 * @param $guildOrUserId
 * @param $bannerHash
 * @param int $size
 * @param string $format
 * @param bool $allowAnimated
 * @return string Discord CDN Guild/User Banner URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getBannerUrl($guildOrUserId, $bannerHash, int $size = 256, string $format = 'webp', bool $allowAnimated = true)
{
    if ($allowAnimated && str_starts_with($bannerHash, 'a_')) $format = 'gif';
    return config('discord.cdn_url') . "/banners/{$guildOrUserId}/{$bannerHash}.{$format}?size={$size}";
}

/**
 * @param $guildId
 * @param $bannerHash
 * @param int $size
 * @param string $format
 * @param bool $allowAnimated
 * @return string Discord CDN User Banner URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getClanBannerUrl($guildId, $bannerHash, int $size = 256, string $format = 'webp', bool $allowAnimated = true)
{
    if ($allowAnimated && str_starts_with($bannerHash, 'a_')) $format = 'gif';
    return config('discord.cdn_url') . "/clan-banners/{$guildId}/{$bannerHash}.{$format}?size={$size}";
}

/**
 * @param $scheduledEventId
 * @param $scheduledEventCoverImage
 * @param int $size
 * @param string $format
 * @return string Discord CDN Guild Scheduled Event Cover URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getGuildScheduledEventCoverUrl($scheduledEventId, $scheduledEventCoverImage, int $size = 64, string $format = 'webp')
{
    return config('discord.cdn_url') . "/guild-events/{$scheduledEventId}/{$scheduledEventCoverImage}.{$format}?size={$size}";
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
    return config('discord.cdn_url') . "/emojis/{$emojiId}.{$format}?size={$size}";
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
    return config('discord.cdn_url') . "/stickers/{$stickerId}.{$format}?size={$size}";
}

/**
 * @param $applicationId
 * @param $icon
 * @param int $size
 * @param string $format
 * @return string Discord CDN Application Icon URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getApplicationIconUrl($applicationId, $icon, int $size = 128, string $format = 'webp')
{
    return config('discord.cdn_url') . "/app-icons/{$applicationId}/{$icon}.{$format}?size={$size}";
}

/**
 * @param $applicationId
 * @param $coverImage
 * @param int $size
 * @param string $format
 * @return string Discord CDN Application Cover URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getApplicationCoverUrl($applicationId, $coverImage, int $size = 128, string $format = 'webp')
{
    return config('discord.cdn_url') . "/app-icons/{$applicationId}/{$coverImage}.{$format}?size={$size}";
}

/**
 * @param $guildId
 * @param $badgeHash
 * @param int $size
 * @param string $format
 * @return string Discord CDN Clan Badge URL
 * @see https://discord.com/developers/docs/reference#image-formatting
 */
function getClanBadgeUrl($guildId, $badgeHash, int $size = 128, string $format = 'webp')
{
    return config('discord.cdn_url') . "/clan-badges/{$guildId}/{$badgeHash}.{$format}?size={$size}";
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


/**
 * @param $boostLevel
 * @return string
 */
function getDiscordBadgeServerBoosts($boostLevel)
{
    return "<img src=\"" . asset('images/discord/icons/boosts/boost-' . $boostLevel . '.svg') . "\" class=\"inline-block h-4 w-4 mb-0.5 mr-px\" alt=\"Boost Level {$boostLevel}\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Boost Level {$boostLevel}\">";
}

/**
 * @param $text
 * @return string
 * @see https://support.discord.com/hc/en-us/articles/210298617-Markdown-Text-101-Chat-Formatting-Bold-Italic-Underline-#h_01GY0DAWJX3CS91G9F1PPJAVBX
 */
function renderDiscordMarkdown($text) {
    // PLEASE DO NOT CHANGE THE ORDER!

    // Underline Bold Italics
    $text = preg_replace('/__(\*\*\*|___)(.*?)\1__/', '<span class="underline font-bold italic">$2</span>', $text);

    // Bold Italics
    $text = preg_replace('/(\*\*\*|___)(.*?)\1/', '<span class="font-bold italic">$2</span>', $text);

    // Underline Bold
    $text = preg_replace('/__(\*\*|__)(.*?)\1__/', '<span class="underline font-bold">$2</span>', $text);

    // Underline Italics
    $text = preg_replace('/__(\*|_)(.*?)\1__/', '<span class="underline italic">$2</span>', $text);

    // Underline
    $text = preg_replace('/__(.*?)__/', '<span class="underline">$1</span>', $text);

    // Bold
    $text = preg_replace('/(\*\*)(.*?)\1/', '<span class="font-bold">$2</span>', $text);

    // Italics
    $text = preg_replace('/(\*|_)(.*?)\1/', '<span class="italic">$2</span>', $text);

    // Strikethrough
    $text = preg_replace('/~~(.*?)~~/', '<span class="line-through">$1</span>', $text);

    // Links
    $text = preg_replace('/(http|https):\/\/([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])/', '<a href="$0" rel="nofollow noopener" target="_blank" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">$0</a>', $text);

    // Line break
    $text = str_replace("\n", "<br>", $text);

    return $text;
}


/**
 * Check if the user agent is Discordbot
 *
 * @param $userAgent
 * @return bool
 */
function isDiscordUserAgent($userAgent)
{
    // Mozilla/5.0 (compatible; Discordbot/2.0; +https://discordapp.com)
    return str_contains($userAgent, 'Discordbot');
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
        'avatarUrlOg' => '',
        'avatarDecorationUrl' => '',
        'avatarDecorationSku' => '',
        'bannerUrl' => '',
        'bannerColor' => '',
        'accentColor' => '',
        'flags' => '',
        'flagsList' => [],
        'premiumType' => 0,
        'premiumTypeName' => '',
        'isBot' => '',
        'isVerifiedBot' => '',
        'isSpammer' => false,
        'clan' => [],
    ];

    if(Cache::has('user:' . $userId))
    {
        $responseJson = Cache::get('user:' . $userId);
    }
    else
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . config('discord.bot_token'),
        ])->get(config('discord.api_url') . '/users/' . $userId);

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

    if (key_exists('avatar', $responseJson) && $responseJson['avatar'] != null) {
        $array['avatarUrl'] = getUserAvatarUrl($responseJson['id'], $responseJson['avatar'], 512, 'webp', true);
        $array['avatarUrlOg'] = getUserAvatarUrl($responseJson['id'], $responseJson['avatar'], 256, 'png', true);
    }

    if (empty($array['avatarUrl'])) {
        $array['avatarUrl'] = getDefaultUserAvatarUrl($responseJson['id']);
        $array['avatarUrlOg'] = getDefaultUserAvatarUrl($responseJson['id']);
    }

    // TODO: Add custom avatar decorations once released and documented by Discord
    if (key_exists('avatar_decoration_data', $responseJson) && $responseJson['avatar_decoration_data'] != null && key_exists('asset', $responseJson['avatar_decoration_data']) && $responseJson['avatar_decoration_data']['asset'] != null)
        $array['avatarDecorationUrl'] = config('discord.cdn_url') . '/avatar-decoration-presets/' . $responseJson['avatar_decoration_data']['asset'] . '?size=512';

    if (key_exists('avatar_decoration_data', $responseJson) && $responseJson['avatar_decoration_data'] != null && key_exists('sku_id', $responseJson['avatar_decoration_data']) && $responseJson['avatar_decoration_data']['sku_id'] != null)
        $array['avatarDecorationSku'] = $responseJson['avatar_decoration_data']['sku_id'];

    if (key_exists('banner', $responseJson) && $responseJson['banner'] != null)
        $array['bannerUrl'] = getBannerUrl($responseJson['id'], $responseJson['banner'], 512, 'webp', true);

    if (key_exists('banner_color', $responseJson) && $responseJson['banner_color'] != null)
        $array['bannerColor'] = $responseJson['banner_color'];

    if (key_exists('accent_color', $responseJson) && $responseJson['accent_color'] != null)
        $array['accentColor'] = '#' . str_pad(dechex($responseJson['accent_color']), 6, '0', STR_PAD_LEFT);

    if (key_exists('public_flags', $responseJson))
    {
        $array['flags'] = $responseJson['public_flags'];
        $array['flagsList'] = getUserFlagList($array['flags']);
        if ($array['flags'] & (1 << 16))
            $array['isVerifiedBot']  = true;

        if ($array['flags'] & (1 << 20))
            $array['isSpammer']  = true;
    }

    if (key_exists('premium_type', $responseJson) && $responseJson['premium_type'] != null) {
        $array['premiumType'] = $responseJson['premium_type'];
        $array['premiumTypeName'] = getPremiumType($responseJson['premium_type']);
    }

    if (key_exists('clan', $responseJson) && $responseJson['clan'] != null)
        $array['clan'] = $responseJson['clan'];

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
        'widgetEnabled' => false,
    ];

    if(Cache::has('guildWidget:' . $guildId))
    {
        $responseJson = Cache::get('guildWidget:' . $guildId);
    }
    else
    {
        $response = Http::get(config('discord.api_url') . '/guilds/' . $guildId . '/widget.json');

        if ($response->status() == 403 && $response->json()['code'] == 50004)
            return array_merge($array, ['id' => $guildId]);

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
        $array['instantInviteUrl'] = empty($array['instantInviteUrlCode']) ? '' : config('discord.invite_prefix') . $array['instantInviteUrlCode'];
    }

    if(array_key_exists('presence_count', $responseJson))
        $array['onlineCount'] = $responseJson['presence_count'];

    if(array_key_exists('channels', $responseJson))
        $array['channels'] = $responseJson['channels'];

    if(array_key_exists('members', $responseJson))
        $array['members'] = $responseJson['members'];

    $array['widgetEnabled'] = true;

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
        'iconUrl' => getDefaultUserAvatarUrl(),
        'splashUrl' => '',
        'discoverySplashUrl' => '',
        'features' => [],
        'isPartnered' => false,
        'isVerified' => false,
        'memberCount' => 0,
        'onlineCount' => 0,
        'emojis' => '',
        'stickers' => '',
        'previewEnabled' => false,
    ];

    if(Cache::has('guildPreview:' . $guildId))
    {
        $responseJson = Cache::get('guildPreview:' . $guildId);
    }
    else
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . config('discord.bot_token'),
        ])->get(config('discord.api_url') . '/guilds/' . $guildId . '/preview');

        if(!$response->ok())
            return null;

        $responseJson = $response->json();
        Cache::put('guildPreview:' . $guildId, $responseJson, 900); // 15 minutes
    }

    if ($responseJson == null || !key_exists('id', $responseJson))
        return null;

    if(array_key_exists('id', $responseJson))
        $array['id'] = $responseJson['id'];

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
        $array['iconUrl'] = getGuildIconUrl($responseJson['id'], $responseJson['icon']);

    if(array_key_exists('splash', $responseJson) && $responseJson['splash'] != null)
        $array['splashUrl'] = config('discord.cdn_url') . '/splashes/' . $array['id'] . '/' . $responseJson['splash'];

    if(array_key_exists('discovery_splash', $responseJson) && $responseJson['discovery_splash'] != null)
        $array['discoverySplashUrl'] = config('discord.cdn_url') . '/discovery-splashes/' . $array['id'] . '/' . $responseJson['discovery_splash'];

    foreach ($responseJson['features'] as $feature)
    {
        if($feature == 'PARTNERED')
            $array['isPartnered'] = true;
        if($feature == 'VERIFIED')
            $array['isVerified'] = true;

        $array['features'][] .= strtolower(str_replace('_', ' ', $feature));
    }
    sort($array['features']);

    $array['previewEnabled'] = true;

    return $array;
}

/**
 * @param $guildId
 * @return array|null
 */
function getDiscoveryClan($guildId)
{
    $array = [
        'id' => '',
        'name' => '',
        'tag' => '',
        'description' => '',
        'memberCount' => 0,
        'badgeUrl' => '',
        'iconUrl' => getDefaultUserAvatarUrl(),
        'bannerUrl' => '',
        'playstyle' => 0,
        'playstyleName' => '',
        'badgeColorPrimary' => '',
        'badgeColorSecondary' => '',
        'searchTerms' => [],
        'wildcardDescriptors' => [],
        'gameIds' => [],
    ];

    if(Cache::has('clanDiscovery:' . $guildId))
    {
        $responseJson = Cache::get('clanDiscovery:' . $guildId);
    }
    else
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . config('discord.bot_token'),
        ])->get(config('discord.api_url') . '/discovery/' . $guildId . '/clan');

        if(!$response->ok())
            return null;

        $responseJson = $response->json();
        Cache::put('clanDiscovery:' . $guildId, $responseJson, 900); // 15 minutes
    }

    if ($responseJson == null || !key_exists('id', $responseJson))
        return null;

    if(array_key_exists('id', $responseJson))
        $array['id'] = $responseJson['id'];

    if(array_key_exists('name', $responseJson))
        $array['name'] = $responseJson['name'];

    if(array_key_exists('tag', $responseJson))
        $array['tag'] = $responseJson['tag'];

    if(array_key_exists('description', $responseJson))
        $array['description'] = $responseJson['description'];

    if(array_key_exists('member_count', $responseJson))
        $array['memberCount'] = $responseJson['member_count'];

    if(array_key_exists('badge_hash', $responseJson) && $responseJson['badge_hash'] != null)
        $array['badgeUrl'] = getClanBadgeUrl($responseJson['id'], $responseJson['badge_hash']);

    if(array_key_exists('icon_hash', $responseJson) && $responseJson['icon_hash'] != null)
        $array['iconUrl'] = getGuildIconUrl($responseJson['id'], $responseJson['icon_hash']);

    if(array_key_exists('banner_hash', $responseJson) && $responseJson['banner_hash'] != null)
        $array['bannerUrl'] = getClanBannerUrl($responseJson['id'], $responseJson['banner_hash']);

    if(array_key_exists('playstyle', $responseJson)) {
        $array['playstyle'] = $responseJson['playstyle'];
        if ($array['playstyle'] == 0) // NONE
            $array['playstyleName'] = 'Unknown';
        else if ($array['playstyle'] == 1) // SOCIAL
            $array['playstyleName'] = 'Very Casual';
        else if ($array['playstyle'] == 2) // CASUAL
            $array['playstyleName'] = 'Casual';
        else if ($array['playstyle'] == 3) // COMPETITIVE
            $array['playstyleName'] = 'Competitive';
        else if ($array['playstyle'] == 4) // CREATIVE
            $array['playstyleName'] = '?? Creative ??'; // TODO: Add correct creative playstyle name
        else if ($array['playstyle'] == 5) // VERY_HARDCORE
            $array['playstyleName'] = 'Very Competitive';
        else
            $array['playstyleName'] = 'n/a';
    }

    if(array_key_exists('badge_color_primary', $responseJson))
        $array['badgeColorPrimary'] = $responseJson['badge_color_primary'];

    if(array_key_exists('badge_color_secondary', $responseJson))
        $array['badgeColorSecondary'] = $responseJson['badge_color_secondary'];

    if(array_key_exists('search_terms', $responseJson))
        $array['searchTerms'] = $responseJson['search_terms'];

    if(array_key_exists('wildcard_descriptors', $responseJson))
        $array['wildcardDescriptors'] = $responseJson['wildcard_descriptors'];

    if(array_key_exists('game_ids', $responseJson))
        $array['gameIds'] = $responseJson['game_ids'];

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
            'iconUrl' => getDefaultUserAvatarUrl(),
            'bannerUrl' => '',
            'features' => [],
            'isPartnered' => false,
            'isVerified' => false,
            'isNSFW' => false,
            'isNSFWLevel' => 0,
            'isNSFWLevelName' => '',
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
            'avatarDecorationSku' => '',
            'bannerUrl' => '',
            'bannerColor' => '',
            'accentColor' => '',
            'premiumType' => 0,
            'premiumTypeName' => '',
            'flags' => '',
            'flagsList' => [],
            'isBot' => false,
            'isVerifiedBot' => false,
            'isSpammer' => false,
            'clan' => [],
        ],
        'channel' => [
            'id' => '',
            'name' => '',
            'icon' => '',
            'iconUrl' => getDefaultUserAvatarUrl(),
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
        if ($array['guild']['isNSFWLevel'] == 0)
            $array['guild']['isNSFWLevelName'] = 'Default';
        else if ($array['guild']['isNSFWLevel'] == 1)
            $array['guild']['isNSFWLevelName'] = 'Explicit';
        else if ($array['guild']['isNSFWLevel'] == 2)
            $array['guild']['isNSFWLevelName'] = 'Safe';
        else if ($array['guild']['isNSFWLevel'] == 3)
            $array['guild']['isNSFWLevelName'] = 'Age-Restricted';

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
            $array['guild']['iconUrl'] = getGuildIconUrl($array['guild']['id'], $json['guild']['icon']);

        if(array_key_exists('banner', $json['guild']) && $json['guild']['banner'] != null)
            $array['guild']['bannerUrl'] = getBannerUrl($array['guild']['id'], $json['guild']['banner'], 512, 'webp', true);

        if(array_key_exists('vanity_url_code', $json['guild']))
        {
            $array['guild']['vanityUrlCode'] = $json['guild']['vanity_url_code'];
            $array['guild']['vanityUrl'] = empty($array['guild']['vanityUrlCode']) ? '' : config('discord.invite_prefix') . $array['guild']['vanityUrlCode'];
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
            $array['channel']['iconUrl'] = config('discord.cdn_url') . '/channel-icons/' . $array['channel']['id'] . '/' . $array['channel']['icon'] . '?size=128';
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
            $array['inviter']['avatarUrl'] = getUserAvatarUrl($json['inviter']['id'], $json['inviter']['avatar'], 512, 'webp', true);

        if (empty($array['inviter']['avatarUrl']))
            $array['inviter']['avatarUrl'] = getDefaultUserAvatarUrl($json['inviter']['id']);

        // TODO: Add custom avatar decorations once released and documented by Discord
        if (key_exists('avatar_decoration_data', $json['inviter']) && $json['inviter']['avatar_decoration_data'] != null && key_exists('asset', $json['inviter']['avatar_decoration_data']) && $json['inviter']['avatar_decoration_data']['asset'] != null)
            $array['inviter']['avatarDecorationUrl'] = config('discord.cdn_url') . '/avatar-decoration-presets/' . $json['inviter']['avatar_decoration_data']['asset'] . '?size=512';

        if (key_exists('avatar_decoration_data', $json['inviter']) && $json['inviter']['avatar_decoration_data'] != null && key_exists('sku_id', $json['inviter']['avatar_decoration_data']) && $json['inviter']['avatar_decoration_data']['sku_id'] != null)
            $array['inviter']['avatarDecorationSku'] = $json['inviter']['avatar_decoration_data']['sku_id'];

        if (key_exists('banner', $json['inviter']) && $json['inviter']['banner'] != null)
            $array['inviter']['bannerUrl'] = getBannerUrl($json['inviter']['id'], $json['inviter']['banner'], 512, 'webp', true);

        if (key_exists('banner_color', $json['inviter']) && $json['inviter']['banner_color'] != null)
            $array['inviter']['bannerColor'] = $json['inviter']['banner_color'];

        if (key_exists('accent_color', $json['inviter']) && $json['inviter']['accent_color'] != null)
            $array['inviter']['accentColor'] = '#' . str_pad(dechex($json['inviter']['accent_color']), 6, '0', STR_PAD_LEFT);

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

            if ($array['inviter']['flags'] & (1 << 20))
                $array['inviter']['isSpammer']  = true;
        }

        if (key_exists('clan', $json['inviter']) && $json['inviter']['clan'] != null)
            $array['inviter']['clan'] = $json['inviter']['clan'];
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

/**
 * @param $applicationId
 * @return array|null
 */
function getApplicationRpc($applicationId)
{
    $array = [
        'id' => '',
        'name' => '',
        'description' => '',
        'descriptionFormatted' => '',
        'type' => '',
        'iconUrl' => getDefaultUserAvatarUrl(),
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
        $response = Http::get(config('discord.api_url') . '/applications/' . $applicationId . '/rpc');

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
        $array['descriptionFormatted'] = renderDiscordMarkdown(strip_tags($array['description']));
    }

    if(array_key_exists('type', $responseJson))
        $array['type'] = $responseJson['type'];

    if (key_exists('icon', $responseJson) && $responseJson['icon'] != null)
        $array['iconUrl'] = getApplicationIconUrl($responseJson['id'], $responseJson['icon']);

    if (key_exists('cover_image', $responseJson) && $responseJson['cover_image'] != null)
        $array['coverImageUrl'] = getApplicationCoverUrl($responseJson['id'], $responseJson['cover_image']);

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
