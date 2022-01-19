<?php

namespace App\Http\Livewire;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class GuildLookup extends Component
{
    use WithRateLimiting;

    public $isLoggedIn = true;
    public $rateLimitHit = false;
    public $rateLimitAvailableIn = 0;

    public $snowflake = "";
    public $found = false;
    public $template = "";

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
    public $guildEmojis = [];
    public $inviteChannelId = "";
    public $inviteChannelName = "";

    public $ogSiteName = "";
    public $ogTitle = "";
    public $ogImage = "";
    public $ogDescription = "";

    protected $listeners = ['fetchSnowflake', 'parseInviteJson'];

    public function fetchSnowflake() {

        $snowflake = $this->snowflake;
        $this->reset();
        $this->snowflake = $snowflake;

        $this->isLoggedIn = auth()->check();
        if (!$this->isLoggedIn) return;

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

            if ($this->fetchGuild()) {
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

    public function getOpenGraph() {
        if(is_numeric($this->snowflake) && $this->snowflake >= 4194304) {
            if($this->fetchGuild()) {
                $this->ogSiteName = $this->guildId;
                $this->ogTitle = $this->guildName;
                $this->ogImage = $this->guildIconUrl;
                $this->ogDescription .= "Created: " . date('Y-m-d H:i:s', (($this->guildId >> 22) + 1420070400000) / 1000) . "\n";

                if($this->guildDescription)
                    $this->ogDescription .= "\n" . $this->guildDescription . "\n\n";

                if($this->guildOnlineCount && $this->guildMemberCount) {
                    $this->ogDescription .= "Online: " . number_format($this->guildOnlineCount, 0, '', '.') . " | Members: " . number_format($this->guildMemberCount, 0, '', '.') . "\n";
                }else{
                    if($this->guildOnlineCount)
                        $this->ogDescription .= "Online: " . number_format($this->guildOnlineCount, 0, '', '.') . "\n";

                    if($this->guildMemberCount)
                        $this->ogDescription .= "Members: " . number_format($this->guildMemberCount, 0, '', '.') . "\n";
                }

                if($this->guildIsVerified && $this->guildIsPartnered) {
                    $this->ogDescription .= "Verified: Yes | Partner: Yes\n";
                }else{
                    if($this->guildIsVerified)
                        $this->ogDescription .= "Verified: Yes\n";

                    if($this->guildIsPartnered)
                        $this->ogDescription .= "Partner: Yes\n";
                }

                if(!empty($this->guildFeatures))
                    $this->ogDescription .= "Features: " . sizeof($this->guildFeatures) . "\n";

                if(!empty($this->guildEmojis))
                    $this->ogDescription .= "Emojis: " . sizeof($this->guildEmojis) . "\n";

                if($this->guildIsNSFW)
                    $this->ogDescription .= "NSFW: " . $this->guildIsNSFW . " (LVL " . $this->guildIsNSFWLevel . ")\n";
            }
        }
    }

    private function fetchGuild() {

        $return = false;

        $guildWidget = [];
        if(Cache::has('guildWidget:' . $this->snowflake)) {
            $guildWidget = Cache::get('guildWidget:' . $this->snowflake);
        } else {
            $responseWidget = Http::withHeaders([
                'Authorization' => "Bot " . env('DISCORD_BOT_TOKEN'),
            ])->get(env('DISCORD_API_URL') . '/guilds/' . $this->snowflake . '/widget.json');

            if($responseWidget->ok()) {
                $guildWidget = $responseWidget->json();
                Cache::put('guildWidget:' . $this->snowflake, $guildWidget, 900); // 15 minutes
            }
        }
        if (!empty($guildWidget) && key_exists('id', $guildWidget)) {
            $this->guildId = $guildWidget['id'];
            $this->guildName = $guildWidget['name'];
            $this->guildInstantInvite = str_replace('https://discord.com/invite/', '', $guildWidget['instant_invite']);
            $this->guildOnlineCount = $guildWidget['presence_count'];

            $return = true;
        }


        $guild = [];
        if(Cache::has('guildPreview:' . $this->snowflake)) {
            $guild = Cache::get('guildPreview:' . $this->snowflake);
        } else {
            $responsePreview = Http::withHeaders([
                'Authorization' => "Bot " . env('DISCORD_BOT_TOKEN'),
            ])->get(env('DISCORD_API_URL') . '/guilds/' . $this->snowflake . '/preview');

            if($responsePreview->ok()) {
                $guild = $responsePreview->json();
                Cache::put('guildPreview:' . $this->snowflake, $guild, 900); // 15 minutes
            }
        }

        if(!empty($guild)) {
            $this->guildId = $guild['id'];
            $this->guildName = $guild['name'];
            $this->guildDescription = $guild['description'];

            if($guild['icon'] != null)
                $this->guildIconUrl = "https://cdn.discordapp.com/icons/" . $this->guildId . "/" . $guild['icon'] . "?size=128";

            foreach ($guild['features'] as $feature) {
                if($feature == 'PARTNERED') $this->guildIsPartnered = true;
                if($feature == 'VERIFIED') $this->guildIsVerified = true;

                $feature = strtolower(str_replace("_", " ", $feature));
                if (!in_array($feature, $this->guildFeatures))
                    $this->guildFeatures[] .= $feature;
            }
            sort($this->guildFeatures);

            if(array_key_exists('approximate_member_count', $guild))
                $this->guildMemberCount = $guild['approximate_member_count'];

            if(array_key_exists('approximate_presence_count', $guild))
                $this->guildOnlineCount = $guild['approximate_presence_count'];

            if(array_key_exists('emojis', $guild))
                $this->guildEmojis = $guild['emojis'];

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

                if($json['guild']['icon'] != null)
                    $this->guildIconUrl = "https://cdn.discordapp.com/icons/" . $this->guildId . "/" . $json['guild']['icon'] . "?size=128";

                if(array_key_exists('banner', $json['guild']) && $json['guild']['banner'] != null)
                    $this->guildBannerUrl = "https://cdn.discordapp.com/banners/" . $this->guildId . "/" . $json['guild']['banner'] . "?size=512";

                foreach ($json['guild']['features'] as $feature) {
                    if($feature == 'PARTNERED') $this->guildIsPartnered = true;
                    if($feature == 'VERIFIED') $this->guildIsVerified = true;

                    $feature = strtolower(str_replace("_", " ", $feature));
                    if (!in_array($feature, $this->guildFeatures)) {
                        $this->guildFeatures[] .= $feature;
                    }
                }
                sort($this->guildFeatures);

                $this->guildIsNSFW = $json['guild']['nsfw'];
                $this->guildIsNSFWLevel = $json['guild']['nsfw_level'];

                if(array_key_exists('vanity_url_code', $json['guild'])) {
                    $this->guildVanityUrlCode = $json['guild']['vanity_url_code'];
                    $this->guildVanityUrl = "https://discord.gg/" . $this->guildVanityUrlCode;
                }
            }

            if(array_key_exists('approximate_member_count', $json))
                $this->guildMemberCount = $json['approximate_member_count'];

            if(array_key_exists('approximate_presence_count', $json))
                $this->guildOnlineCount = $json['approximate_presence_count'];

            if(array_key_exists('channel', $json)) {
                if(array_key_exists('id', $json['channel']))
                    $this->inviteChannelId = $json['channel']['id'];

                if(array_key_exists('name', $json['channel']))
                    $this->inviteChannelName = $json['channel']['name'];
            }
        }
    }

    public function mount() {
        $this->getOpenGraph();
    }

    public function render()
    {
        return view('livewire.guild-lookup');
    }
}
