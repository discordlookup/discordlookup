<?php

namespace App\Http\Livewire;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class UserLookup extends Component
{

    use WithRateLimiting;

    public $isLoggedIn = true;
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

    protected $listeners = ['fetchSnowflake'];

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

            if($this->fetchUser()) {
                $this->found = true;
                $this->template = "user";
            }else{
                $this->found = false;
                $this->template = "notfound";
            }
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
        return view('livewire.user-lookup');
    }
}
