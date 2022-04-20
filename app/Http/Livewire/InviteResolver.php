<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InviteResolver extends Component
{

    public $found = true;
    public $inviteHasEvent = false;
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

    public $eventId = "";
    public $eventChannelId = "";
    public $eventCreatorId = "";
    public $eventName = "";
    public $eventDescription = "";
    public $eventImage = ""; // Soon?
    public $eventStartTime = "";
    public $eventEndTime = "";
    public $eventPrivacyLevel = 2;
    public $eventStatus = 1;
    public $eventEntityType = "";
    public $eventEntityId = "";
    public $eventEntityMetadataLocation = "";
    public $eventUserCount = 0;
    public $eventStartFormatted = "";
    public $eventEndFormatted = "";

    protected $listeners = ['parseJson'];

    public function parseJson($json, $inviteExpiresAtFormatted, $eventStartFormatted, $eventEndFormatted) {

        $this->reset();

        if($json != null) {
            if(array_key_exists('guild', $json)) {
                $this->guildId = $json['guild']['id'];
                $this->guildName = $json['guild']['name'];
                $this->guildDescription = $json['guild']['description'];

                if($json['guild']['icon'] != null) {
                    $this->guildIconUrl = "https://cdn.discordapp.com/icons/" . $this->guildId . "/" . $json['guild']['icon'] . "?size=128";
                }

                if(array_key_exists('banner', $json['guild']) && $json['guild']['banner'] != null) {
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

            if(array_key_exists("guild_scheduled_event", $json)) {
                $this->inviteHasEvent = true;

                $this->eventId = $json['guild_scheduled_event']['id'];
                $this->eventChannelId = $json['guild_scheduled_event']['channel_id'];
                $this->eventCreatorId = $json['guild_scheduled_event']['creator_id'];
                $this->eventName = $json['guild_scheduled_event']['name'];
                $this->eventDescription = $json['guild_scheduled_event']['description'];
                $this->eventImage = $json['guild_scheduled_event']['image'];
                $this->eventStartTime = $json['guild_scheduled_event']['scheduled_start_time'];
                $this->eventEndTime = $json['guild_scheduled_event']['scheduled_end_time'];
                switch ($json['guild_scheduled_event']['privacy_level']) {
                    case 2:
                        $this->eventPrivacyLevel = "GUILD_ONLY";
                        break;
                    default:
                        $this->eventPrivacyLevel = $json['guild_scheduled_event']['privacy_level'];
                        break;
                }
                switch ($json['guild_scheduled_event']['status']) {
                    case 1:
                        $this->eventStatus = '<span class="badge bg-warning text-black">SCHEDULED</span>';
                        break;
                    case 2:
                        $this->eventStatus = '<span class="badge bg-success text-black">ACTIVE</span>';
                        break;
                    case 3:
                        $this->eventStatus = '<span class="badge bg-primary">COMPLETED</span>';
                        break;
                    case 4:
                        $this->eventStatus = '<span class="badge bg-danger">CANCELED</span>';
                        break;
                    default:
                        $this->eventStatus = $json['guild_scheduled_event']['status'];
                        break;
                }
                switch ($json['guild_scheduled_event']['entity_type']) {
                    case 1:
                        $this->eventEntityType = "STAGE_INSTANCE";
                        break;
                    case 2:
                        $this->eventEntityType = "VOICE";
                        break;
                    case 3:
                        $this->eventEntityType = "EXTERNAL";
                        break;
                    default:
                        $this->eventEntityType = $json['guild_scheduled_event']['entity_type'];
                        break;
                }
                $this->eventEntityId = $json['guild_scheduled_event']['entity_id'];

                if(array_key_exists("entity_metadata", $json['guild_scheduled_event'])) {
                    if($json['guild_scheduled_event']['entity_metadata'] != null && array_key_exists("location", $json['guild_scheduled_event']['entity_metadata'])) {
                        $this->eventEntityMetadataLocation = $json['guild_scheduled_event']['entity_metadata']['location'];
                    }
                    // speaker_ids soon?
                }

                $this->eventUserCount = $json['guild_scheduled_event']['user_count'];
                $this->eventStartFormatted = $eventStartFormatted;
                $this->eventEndFormatted = $eventEndFormatted;
            }

        }else{
            $this->found = false;
        }
    }

    public function render()
    {
        return view('livewire.invite-resolver');
    }
}
