<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Website
|--------------------------------------------------------------------------
*/

Route::get('/', \App\Http\Livewire\Home::class)->name('home');

/* Snowflakes */
Route::get('/snowflake/{snowflake?}', \App\Http\Livewire\Snowflake::class)->name('snowflake');
Route::get('/user/{snowflake?}', \App\Http\Livewire\Lookup\User::class)->name('userlookup');
Route::get('/guild/{snowflake?}', \App\Http\Livewire\Lookup\Guild::class)->name('guildlookup');
Route::get('/application/{snowflake?}', \App\Http\Livewire\Lookup\Application::class)->name('applicationlookup');
Route::get('/snowflake-distance/{snowflake1?}/{snowflake2?}', \App\Http\Livewire\SnowflakeDistance::class)->name('snowflake-distance-calculator');

Route::get('/guildlist', \App\Http\Livewire\Guildlist::class)->name('guildlist');

Route::get('/timestamp/{timestampSlug?}', \App\Http\Livewire\Timestamp::class)->name('timestamp');

/* Experiments */
Route::name('experiments.')->group(function () {
    Route::get('/experiments', \App\Http\Livewire\Experiments\Index::class)->name('index');
    Route::get('/experiments/{experimentId}', \App\Http\Livewire\Experiments\Show::class)->name('show');
    Route::redirect('/experiment/{experimentId}', '/experiments/{experimentId}', 301);
});

/* Other */
Route::get('/inviteresolver/{inviteCode?}/{eventId?}', \App\Http\Livewire\InviteResolver::class)->name('inviteresolver');

Route::get('/permissions-calculator/{permissions?}', \App\Http\Livewire\PermissionsCalculator::class)->name('permissions-calculator');
Route::get('/guild-shard-calculator/{guildId?}/{totalShards?}', \App\Http\Livewire\GuildShardCalculator::class)->name('guild-shard-calculator');
Route::get('/webhook-invalidator', \App\Http\Livewire\WebhookInvalidator::class)->name('webhook-invalidator');
Route::get('/domains', \App\Http\Livewire\Domains::class)->name('domains');
Route::get('/murmurhash', \App\Http\Livewire\Murmurhash::class)->name('murmurhash');
Route::get('/help', \App\Http\Livewire\Help::class)->name('help');

Route::name('legal.')->group(function () {
    Route::get('/legal-notice', \App\Http\Livewire\Legal\LegalNotice::class)->name('legalnotice');
    Route::get('/privacy-policy', \App\Http\Livewire\Legal\PrivacyPolicy::class)->name('privacypolicy');
    Route::get('/terms-of-service', \App\Http\Livewire\Legal\TermsOfService::class)->name('terms-of-service');
});


/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/login/verify-role-connection', [\App\Http\Controllers\AuthController::class, 'loginWithRoleConnections'])->name('login.verify-role-connection');
Route::get('/auth/callback', [\App\Http\Controllers\AuthController::class, 'callback']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Redirects
|--------------------------------------------------------------------------
*/

Route::redirect('/invite', config('discord.invite_url'), 302)->name('invite');
Route::redirect('/discord', config('app.discord_url'), 302)->name('discord');


/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/

/*Route::get('/language/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return Redirect::back();
})->name('language.switch');*/
