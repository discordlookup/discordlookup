<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LandingController::class, 'home'])->name('home');
Route::get('/snowflake/{snowflake?}', [LandingController::class, 'snowflake'])->name('snowflake');
Route::get('/guildlist', [LandingController::class, 'guildlist'])->name('guildlist');
Route::get('/inviteinfo/{code?}', [LandingController::class, 'inviteinfo'])->name('inviteinfo');
Route::get('/snowflake-distance-calculator/{snowflake1?}/{snowflake2?}', [LandingController::class, 'snowflakedistancecalculator'])->name('snowflake-distance-calculator');
Route::get('/guild-shard-calculator/{guildId?}/{totalShards?}', [LandingController::class, 'guildshardcalculator'])->name('guild-shard-calculator');
Route::get('/help', [LandingController::class, 'help'])->name('help');

Route::name('legal.')->group(function () {
    Route::get('/imprint', [LegalController::class, 'imprint'])->name('imprint');
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
    //Route::get('/terms-of-service', [LegalController::class, 'termsofservice'])->name('terms-of-service');
});

/* Auth (Discord) */
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/callback', [AuthController::class, 'callback']);
