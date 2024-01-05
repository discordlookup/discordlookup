<?php

namespace App\Http\Livewire\Lookup;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use F9Web\Meta\Meta;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class User extends Component
{
    use WithRateLimiting;

    public $fetched = false;
    public $snowflake;
    public $userData;
    public $errorMessage;

    public $rateLimitHit = false;
    public $rateLimitAvailableIn = 0;

    protected $listeners = ['fetchUser'];

    public function fetchUser()
    {
        $this->resetExcept(['snowflake']);

        if($this->snowflake == null) return;

        $this->errorMessage = invalidateSnowflake($this->snowflake);
        if($this->errorMessage) return;

        if (App::environment('production')) {
            try {
                $this->rateLimit(auth()->check() ? 10 : 3, auth()->check() ? 2 * 60 : 3 * 60);
            } catch (TooManyRequestsException $exception) {
                $this->rateLimitHit = true;
                $this->rateLimitAvailableIn = $exception->secondsUntilAvailable;
                return;
            }
        }

        $this->fetched = true;
        $this->userData = getUser($this->snowflake);
    }

    public function mount()
    {
        if($this->snowflake)
            $this->fetchUser();

        $userAgent = request()->header('User-Agent');
        if ($this->userData && isDiscordUserAgent($userAgent)) {

            $username = '@' . $this->userData['username'];
            if ($this->userData['discriminator'] != '0')
                $username .= '#' . $this->userData['discriminator'];

            $description = 'ID: ' . $this->userData['id'] . '
';
            $description .= 'Created: ' . \Carbon\Carbon::createFromTimestamp(getTimestamp($this->userData['id']) / 1000)->diffForHumans() . '
';

            if($this->userData['isBot']) {
                $description .= 'Bot: Yes
';
                if($this->userData['isVerifiedBot'] || $this->userData['id'] === '643945264868098049' || $this->userData['id'] === '1081004946872352958') {
                    $description .= 'Verified Bot: Yes
';
                }else{
                    $description .= 'Verified Bot: No
';
                }
            }else{
                $description .= 'Bot: No
';
            }

            if($this->userData['bannerColor'])
                $description .= 'Banner Color: ' . $this->userData['bannerColor'] . '
';

            if($this->userData['accentColor'])
                $description .= 'Accent Color: ' . $this->userData['accentColor'] . '
';

            if(!empty($this->userData['flagsList'])) {
                $description .= '
Badges:
';
                foreach($this->userData['flagsList'] as $flag) {
                    $description .= '• ' . $flag['name'] . '
';
                }
            }

            Meta::set('og:site_name', $username)
                ->set('og:title', $this->userData['global_name'])
                ->set('og:description', $description)
                ->set('og:image', $this->userData['avatarUrlOg'])
                ->when($this->userData['bannerColor'], function ($meta) {
                    $meta->set('theme-color', $this->userData['bannerColor']);
                });
        }else{
            Meta::set('title', __('User Lookup'))
                ->set('og:title', __('User Lookup'))
                ->set('description', __('Get detailed information about Discord users with creation date, profile picture, banner and badges.'))
                ->set('og:description', __('Get detailed information about Discord users with creation date, profile picture, banner and badges.'))
                ->set('keywords', 'user, member, user lookup, member info, user info, user search, member search, username, discord user, ' . getDefaultKeywords());
        }
    }

    public function render()
    {
        return view('lookup.user')->extends('layouts.app');
    }
}
