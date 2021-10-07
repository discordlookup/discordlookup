<?php

namespace App\Http\Livewire;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SnowflakeSearch extends Component
{

    use WithRateLimiting;

    public $rateLimitHit = false;
    public $rateLimitAvailableIn = 0;

    public $snowflake = "";
    public $found = false;
    public $template = "";

    public $userId = "";
    public $userIsBot = false;
    public $userIsVerifiedBot = false;
    public $userUsername = "";
    public $userDiscriminator = "";
    public $userAboutMe = "";
    public $userAvatarUrl = "https://cdn.discordapp.com/embed/avatars/0.png";
    public $userBannerUrl = "";
    public $userBannerColor = "";
    public $userAccentColor = "";
    public $userFlags = "";
    public $userFlagList = [];

    public $guildId = "";
    public $guildName = "";
    public $guildInstantInvite = "";
    public $guildDescription = "";
    public $guildIconUrl = "https://cdn.discordapp.com/embed/avatars/0.png";
    public $guildBannerUrl = "";
    public $guildFeatures = [];
    public $guildIsPartnered = false;
    public $guildIsVerified = false;
    public $guildIsNSFW = null;
    public $guildIsNSFWLevel = 0;
    public $guildVanityUrlCode = "";
    public $guildVanityUrl = "";
    public $guildMemberCount = null;
    public $guildOnlineCount = null;
    public $inviteChannelId = "";
    public $inviteChannelName = "";

    protected $listeners = ['fetchSnowflake', 'parseInviteJson'];

    public function fetchSnowflake() {

        $snowflake = $this->snowflake;
        $this->reset();
        $this->snowflake = $snowflake;

        if(is_numeric($this->snowflake) && $this->snowflake >= 4194304) {

            try {
                if(auth()->check()) {
                    $this->rateLimit(10, 60);
                }else{
                    $this->rateLimit(3, 3*60);
                }
            } catch (TooManyRequestsException $exception) {
                $this->rateLimitHit = true;
                $this->rateLimitAvailableIn = $exception->secondsUntilAvailable;
                return;
            }

            if($this->fetchUser()) {
                $this->found = true;
                $this->template = "user";
            }elseif ($this->fetchGuild()) {
                $this->found = true;
                $this->template = "guild";
            }else{
                $this->found = false;
                $this->template = "notfound";
            }

            $this->dispatchBrowserEvent('contentChanged', [
                'snowflake' => $this->snowflake,
                'invitecode' => $this->guildInstantInvite,
            ]);
        }
    }

    private function fetchUser() {
        $response = Http::withHeaders([
            'Authorization' => "Bot " . env('DISCORD_BOT_TOKEN'),
        ])->get(env('DISCORD_API_URL') . '/users/' . $this->snowflake);

        $user = $response->json();

        if (key_exists('id', $user)) {

            $this->userId = $user['id'];

            if (key_exists('bot', $user)) {
                $this->userIsBot = $user['bot'];
            }

            $this->userUsername = $user['username'];
            $this->userDiscriminator = $user['discriminator'];

            if (key_exists('avatar', $user) && $user['avatar'] != null) {
                $this->userAvatarUrl = "https://cdn.discordapp.com/avatars/" . $user['id'] . "/" . $user['avatar'] . "?size=512";
            }

            if (key_exists('banner', $user) && $user['banner'] != null) {
                $this->userBannerUrl = "https://cdn.discordapp.com/banners/" . $user['id'] . "/" . $user['banner'] . "?size=512";
            }

            if (key_exists('banner_color', $user) && $user['banner_color'] != null) {
                $this->userBannerColor = $user['banner_color'];
            }

            if (key_exists('accent_color', $user) && $user['accent_color'] != null) {
                $this->userAccentColor = "#" . dechex($user['accent_color']);
            }

            if (key_exists('public_flags', $user)) {
                $this->userFlags = $user['public_flags'];
                if ($this->userFlags & (1 << 16)) $this->userIsVerifiedBot = true;
                $this->userFlagList = $this->getFlagList($this->userFlags);
            }

            return true;
        }

        return false;
    }

    private function fetchGuild() {

        $return = false;

        $response = Http::withHeaders([
            'Authorization' => "Bot " . env('DISCORD_BOT_TOKEN'),
        ])->get(env('DISCORD_API_URL') . '/guilds/' . $this->snowflake . '/widget.json');

        if($response->status() == 200) {
            $guildWidget = $response->json();

            if (key_exists('id', $guildWidget)) {

                $this->guildId = $guildWidget['id'];
                $this->guildName = $guildWidget['name'];
                $this->guildInstantInvite = str_replace('https://discord.com/invite/', '', $guildWidget['instant_invite']);
                $this->guildOnlineCount = $guildWidget['presence_count'];

                $return = true;
            }
        }

        $response = Http::withHeaders([
            'Authorization' => "Bot " . env('DISCORD_BOT_TOKEN'),
        ])->get(env('DISCORD_API_URL') . '/guilds/' . $this->snowflake . '/preview');

        if($response->status() == 200) {

            $guild = $response->json();

            $this->guildId = $guild['id'];
            $this->guildName = $guild['name'];
            $this->guildDescription = $guild['description'];
            if($guild['icon'] != null) {
                $this->guildIconUrl = "https://cdn.discordapp.com/icons/" . $this->guildId . "/" . $guild['icon'] . "?size=128";
            }

            foreach ($guild['features'] as $feature) {
                if($feature == "PARTNERED") $this->guildIsPartnered = true;
                if($feature == "VERIFIED") $this->guildIsVerified = true;

                $feature = strtolower(str_replace("_", " ", $feature));
                if (!in_array($feature, $this->guildFeatures)) {
                    $this->guildFeatures[] .= $feature;
                }
            }
            sort($this->guildFeatures);

            if(array_key_exists("approximate_member_count", $guild)) {
                $this->guildMemberCount = $guild['approximate_member_count'];
            }

            if(array_key_exists("approximate_presence_count", $guild)) {
                $this->guildOnlineCount = $guild['approximate_presence_count'];
            }

            $return = true;
        }

        return $return;
    }

    public function parseInviteJson($json) {
        if($json != null) {
            if(array_key_exists("guild", $json)) {
                $this->guildId = $json['guild']['id'];
                $this->guildName = $json['guild']['name'];
                $this->guildDescription = $json['guild']['description'];
                if($json['guild']['icon'] != null) {
                    $this->guildIconUrl = "https://cdn.discordapp.com/icons/" . $this->guildId . "/" . $json['guild']['icon'] . "?size=128";
                }

                if(array_key_exists("banner", $json['guild']) && $json['guild']['banner'] != null) {
                    $this->guildBannerUrl = "https://cdn.discordapp.com/banners/" . $this->guildId . "/" . $json['guild']['banner'] . "?size=512";
                }

                foreach ($json['guild']['features'] as $feature) {
                    if($feature == "PARTNERED") $this->guildIsPartnered = true;
                    if($feature == "VERIFIED") $this->guildIsVerified = true;

                    $feature = strtolower(str_replace("_", " ", $feature));
                    if (!in_array($feature, $this->guildFeatures)) {
                        $this->guildFeatures[] .= $feature;
                    }
                }
                sort($this->guildFeatures);

                $this->guildIsNSFW = $json['guild']['nsfw'];
                $this->guildIsNSFWLevel = $json['guild']['nsfw_level'];

                if(array_key_exists("vanity_url_code", $json['guild'])) {
                    $this->guildVanityUrlCode = $json['guild']['vanity_url_code'];
                    $this->guildVanityUrl = "https://discord.gg/" . $this->guildVanityUrlCode;
                }
            }

            if(array_key_exists("approximate_member_count", $json)) {
                $this->guildMemberCount = $json['approximate_member_count'];
            }

            if(array_key_exists("approximate_presence_count", $json)) {
                $this->guildOnlineCount = $json['approximate_presence_count'];
            }

            if(array_key_exists("channel", $json)) {
                if(array_key_exists("id", $json['channel'])) {
                    $this->inviteChannelId = $json['channel']['id'];
                }
                if(array_key_exists("name", $json['channel'])) {
                    $this->inviteChannelName = $json['channel']['name'];
                }
            }
        }
    }

    private function getFlagList($flags) {

        $list = [];

        if($flags & (1 << 0)) array_push($list, ['name' => 'Discord Employee', 'image' => asset('images/discord/icons/badges/discord_employee.png')]);
        if($flags & (1 << 1)) array_push($list, ['name' => 'Partnered Server Owner', 'image' => asset('images/discord/icons/badges/partnered_server_owner.png')]);
        if($flags & (1 << 2)) array_push($list, ['name' => 'HypeSquad Events', 'image' => asset('images/discord/icons/badges/hypesquad_events.png')]);
        if($flags & (1 << 3)) array_push($list, ['name' => 'Bug Hunter Level 1', 'image' => asset('images/discord/icons/badges/bug_hunter_level_1.png')]);
        if($flags & (1 << 6)) array_push($list, ['name' => 'HypeSquad House Bravery', 'image' => asset('images/discord/icons/badges/hypesquad-house-bravery.png')]);
        if($flags & (1 << 7)) array_push($list, ['name' => 'HypeSquad House Brilliance', 'image' => asset('images/discord/icons/badges/hypesquad-house-brilliance.png')]);
        if($flags & (1 << 8)) array_push($list, ['name' => 'HypeSquad House Balance', 'image' => asset('images/discord/icons/badges/hypesquad-house-balance.png')]);
        if($flags & (1 << 9)) array_push($list, ['name' => 'Early Supporter', 'image' => asset('images/discord/icons/badges/early_supporter.png')]);
        if($flags & (1 << 10)) array_push($list, ['name' => 'Team User', 'image' => '']);
        if($flags & (1 << 12)) array_push($list, ['name' => 'System User', 'image' => '']);
        if($flags & (1 << 14)) array_push($list, ['name' => 'Bug Hunter Level 2', 'image' => asset('images/discord/icons/badges/bug_hunter_level_2.png')]);
        if($flags & (1 << 16)) array_push($list, ['name' => 'Verified Bot', 'image' => asset('images/discord/icons/badges/verified_bot.svg')]);;
        if($flags & (1 << 17)) array_push($list, ['name' => 'Early Verified Bot Developer', 'image' => asset('images/discord/icons/badges/early-verified-bot-developer.png')]);
        if($flags & (1 << 18)) array_push($list, ['name' => 'Discord Certified Moderator', 'image' => asset('images/discord/icons/badges/discord_certified_moderator.png')]);

        return $list;
    }

    public function render()
    {
        return view('livewire.snowflake-search');
    }
}
