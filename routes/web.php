<?php

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

Route::get('/', [App\Http\Controllers\LandingController::class, 'home'])->name('home');
Route::get('/snowflake/{snowflake?}', [App\Http\Controllers\LandingController::class, 'snowflake'])->name('snowflake');
Route::get('/guildlist', [App\Http\Controllers\LandingController::class, 'guildlist'])->name('guildlist');
Route::get('/inviteinfo/{code?}', [App\Http\Controllers\LandingController::class, 'inviteinfo'])->name('inviteinfo');
Route::get('/help', [App\Http\Controllers\LandingController::class, 'help'])->name('help');

Route::name('legal.')->group(function () {
    Route::get('/imprint', [\App\Http\Controllers\LegalController::class, 'imprint'])->name('imprint');
    Route::get('/privacy', [\App\Http\Controllers\LegalController::class, 'privacy'])->name('privacy');
    //Route::get('/terms-of-service', [\App\Http\Controllers\LegalController::class, 'termsofservice'])->name('terms-of-service');
});

/* Auth (Discord) */
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/auth/callback', [App\Http\Controllers\AuthController::class, 'callback']);
