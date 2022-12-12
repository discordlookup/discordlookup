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
 * @param $bitwise
 * @return array
 * @see https://discord.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags
 */
function getPermissionFlagListNames($bitwise): array
{
    $permissions = [
        'CREATE_INSTANT_INVITE' => (1 << 0),
        'KICK_MEMBERS' => (1 << 1),
        'BAN_MEMBERS' => (1 << 2),
        'ADMINISTRATOR' => (1 << 3),
        'MANAGE_CHANNELS' => (1 << 4),
        'MANAGE_GUILD' => (1 << 5),
        'ADD_REACTIONS' => (1 << 6),
        'VIEW_AUDIT_LOG' => (1 << 7),
        'PRIORITY_SPEAKER' => (1 << 8),
        'STREAM' => (1 << 9),
        'VIEW_CHANNEL' => (1 << 10),
        'SEND_MESSAGES' => (1 << 11),
        'SEND_TTS_MESSAGES' => (1 << 12),
        'MANAGE_MESSAGES' => (1 << 13),
        'EMBED_LINKS' => (1 << 14),
        'ATTACH_FILES' => (1 << 15),
        'READ_MESSAGE_HISTORY' => (1 << 16),
        'MENTION_EVERYONE' => (1 << 17),
        'USE_EXTERNAL_EMOJIS' => (1 << 18),
        'VIEW_GUILD_INSIGHTS' => (1 << 19),
        'CONNECT' => (1 << 20),
        'SPEAK' => (1 << 21),
        'MUTE_MEMBERS' => (1 << 22),
        'DEAFEN_MEMBERS' => (1 << 23),
        'MOVE_MEMBERS' => (1 << 24),
        'USE_VOICE-ACTIVITY-DETECTION'/*USE_VAD*/ => (1 << 25),
        'CHANGE_NICKNAME' => (1 << 26),
        'MANAGE_NICKNAMES' => (1 << 27),
        'MANAGE_ROLES' => (1 << 28),
        'MANAGE_WEBHOOKS' => (1 << 29),
        'MANAGE_EMOJIS_AND_STICKERS' => (1 << 30),
        'USE_APPLICATION_COMMANDS' => (1 << 31),
        'REQUEST_TO_SPEAK' => (1 << 32),
        'MANAGE_THREADS' => (1 << 34),
        'CREATE_PUBLIC_THREADS' => (1 << 35),
        'CREATE_PRIVATE_THREADS' => (1 << 36),
        'USE_EXTERNAL_STICKERS' => (1 << 37),
        'SEND_MESSAGES_IN_THREADS' => (1 << 38),
        'START_EMBEDDED_ACTIVITIES' => (1 << 39),
        'MODERATE_MEMBERS' => (1 << 40),
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
 * @param $bitwise
 * @return array
 * @see https://discord.com/developers/docs/resources/application#application-object-application-flags
 */
function getApplicationFlagListNames($bitwise): array
{
    $permissions = [
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
 * @param $name
 * @param $title
 * @return string
 */
function getDiscordBadgeServerIcons($name, $title)
{
    return "<img src=\"" . asset('images/discord/icons/server/' . $name . '.svg') . "\" class=\"discord-badge\" alt=\"{$name} badge\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$title}\">";
}


function getDiscordBadgeServerBoosts($boostLevel)
{
    return "<img src=\"" . asset('images/discord/icons/boosts/boost-' . $boostLevel . '.svg') . "\" class=\"discord-badge ms-n1\" alt=\"Boost Level {$boostLevel}\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Boost Level {$boostLevel}\">";
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
        'avatarUrl' => env('DISCORD_CDN_URL') . '/embed/avatars/0.png',
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

    $array['id'] = $responseJson['id'];

    if (key_exists('username', $responseJson))
        $array['username'] = $responseJson['username'];

    if (key_exists('discriminator', $responseJson))
        $array['discriminator'] = $responseJson['discriminator'];

    if (key_exists('bot', $responseJson))
        $array['isBot'] = $responseJson['bot'];

    if (key_exists('avatar', $responseJson) && $responseJson['avatar'] != null)
        $array['avatarUrl'] = env('DISCORD_CDN_URL') . '/avatars/' . $responseJson['id'] . '/' . $responseJson['avatar'] . '?size=512';

    if (key_exists('avatar_decoration', $responseJson) && $responseJson['avatar_decoration'] != null)
        $array['avatarDecorationUrl'] = env('DISCORD_CDN_URL') . '/avatar-decorations/' . $responseJson['id'] . '/' . $responseJson['avatar_decoration'] . '?size=512';

    if (key_exists('banner', $responseJson) && $responseJson['banner'] != null)
        $array['bannerUrl'] = env('DISCORD_CDN_URL') . '/banners/' . $responseJson['id'] . '/' . $responseJson['banner'] . '?size=512';

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
        'invite' => [
            'channelId' => '',
            'channelName' => '',
            'inviterId' => '',
            'inviterName' => '',
            'expiresAt' => '',
            'expiresAtFormatted' => '&infin;',
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

    /* Guild */
    if(array_key_exists('guild', $json))
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
            $array['guild']['bannerUrl'] = env('DISCORD_CDN_URL') . '/banners/' . $array['guild']['id'] . '/' . $json['guild']['banner'] . '?size=512';

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
    if(array_key_exists('channel', $json))
    {
        if(array_key_exists('id', $json['channel']))
            $array['invite']['channelId'] = $json['channel']['id'];
        if(array_key_exists('name', $json['channel']))
            $array['invite']['channelName'] = $json['channel']['name'];
    }

    if(array_key_exists('inviter', $json))
    {
        if(array_key_exists('id', $json['inviter']))
            $array['invite']['inviterId'] = $json['inviter']['id'];

        if(array_key_exists('username', $json['inviter']) && array_key_exists('discriminator', $json['inviter']))
            $array['invite']['inviterName'] = $json['inviter']['username'] . '#' . $json['inviter']['discriminator'];
    }

    if(array_key_exists('expires_at', $json) && $json['expires_at'] != null)
    {
        $array['invite']['expiresAt'] = $json['expires_at'];
        $array['invite']['expiresAtFormatted'] = date('Y-m-d G:i:s \(T\)', strtotime($array['invite']['expiresAt']));
    }

    /* Event */
    if(array_key_exists('guild_scheduled_event', $json))
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
                $array['event']['status'] = '<span class="badge bg-warning text-black">SCHEDULED</span>';
                break;
            case 2:
                $array['event']['status'] = '<span class="badge bg-success text-black">ACTIVE</span>';
                break;
            case 3:
                $array['event']['status'] = '<span class="badge bg-primary">COMPLETED</span>';
                break;
            case 4:
                $array['event']['status'] = '<span class="badge bg-danger">CANCELED</span>';
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
        'summary' => '',
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

    if(array_key_exists('summary', $responseJson))
        $array['summary'] = $responseJson['summary'];

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
