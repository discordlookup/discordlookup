<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Inviteinfo extends Component
{

    public $found = true;
    public $inviteCode = "";
    public $guildId = "";
    public $guildName = "";
    public $guildDescription = "";
    public $guildIconUrl = "https://cdn.discordapp.com/embed/avatars/0.png";
    public $guildBannerUrl = "";
    public $guildFeatures = [];
    public $guildIsPartnered = false;
    public $guildIsVerified = false;
    public $guildIsNSFW = false;
    public $guildIsNSFWLevel = 0;
    public $guildVanityUrlCode = "";
    public $guildVanityUrl = "";
    public $guildMemberCount = 0;
    public $guildOnlineCount = 0;
    public $inviteChannelId = "";
    public $inviteChannelName = "";
    public $inviteInviterId = "";
    public $inviteInviterName = "";
    public $inviteExpiresAt = "";
    public $inviteExpiresAtFormatted = "&infin;";

    protected $listeners = ['parseJson'];

    public function parseJson($json, $inviteExpiresAtFormatted) {

        $this->reset();

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

                    $this->guildFeatures[] .= strtolower(str_replace("_", " ", $feature));
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

            if(array_key_exists("inviter", $json)) {
                if(array_key_exists("id", $json['inviter'])) {
                    $this->inviteInviterId = $json['inviter']['id'];
                }
                if(array_key_exists("username", $json['inviter']) && array_key_exists("discriminator", $json['inviter'])) {
                    $this->inviteInviterName = $json['inviter']['username'] . "#" . $json['inviter']['discriminator'];
                }
            }

            if(array_key_exists("expires_at", $json) && $json['expires_at'] != null) {
                $this->inviteExpiresAt = $json['expires_at'];
                $this->inviteExpiresAtFormatted = $inviteExpiresAtFormatted;
            }
        }else{
            $this->found = false;
        }
    }

    public function render()
    {
        return view('livewire.inviteinfo');
    }
}
