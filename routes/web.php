<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Livewire\Home::class)->name('home');

/* Snowflakes */
Route::get('/snowflake/{snowflake?}', \App\Http\Livewire\Snowflake\Index::class)->name('snowflake');
Route::get('/user/{snowflake?}', \App\Http\Livewire\Lookup\User::class)->name('userlookup');
Route::get('/guild/{snowflake?}', \App\Http\Livewire\Lookup\Guild::class)->name('guildlookup');
Route::get('/application/{snowflake?}', \App\Http\Livewire\Lookup\Application::class)->name('applicationlookup');
Route::get('/snowflake-distance/{snowflake1?}/{snowflake2?}', \App\Http\Livewire\Snowflake\Distance::class)->name('snowflake-distance-calculator');

Route::get('/guildlist', \App\Http\Livewire\Guildlist::class)->name('guildlist');

/* Experiments */
Route::name('experiments.')->group(function () {
    Route::get('/experiments', \App\Http\Livewire\Experiments\Index::class)->name('index');
    Route::get('/experiment/{experimentId}', \App\Http\Livewire\Experiments\Show::class)->name('show');
});

/* Other */
Route::get('/inviteresolver/{inviteCode?}/{eventId?}', \App\Http\Livewire\InviteResolver::class)->name('inviteresolver');

Route::get('/guild-shard-calculator/{guildId?}/{totalShards?}', \App\Http\Livewire\GuildShardCalculator::class)->name('guild-shard-calculator');
Route::get('/help', \App\Http\Livewire\Help::class)->name('help');

Route::name('legal.')->group(function () {
    Route::get('/imprint', [LegalController::class, 'imprint'])->name('imprint');
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('/terms-of-service', [LegalController::class, 'termsofservice'])->name('terms-of-service');
});

/* Auth (Discord) */
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/callback', [AuthController::class, 'callback']);

/* Language switcher */
Route::get('/language/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return Redirect::back();
})->name('language.switch');
