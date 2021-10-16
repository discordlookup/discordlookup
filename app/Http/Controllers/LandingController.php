<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function snowflake($snowflake = "")
    {
        return view('snowflake', ['snowflake' => $snowflake]);
    }

    public function guildlist()
    {
        return view('guildlist');
    }

    public function inviteinfo($code = "")
    {
        return view('inviteinfo', ['code' => $code]);
    }

    public function guildshardcalculator($guildId = "", $totalShards = "")
    {
        return view('guild-shard-calculator', ['guildId' => $guildId, 'totalShards' => $totalShards]);
    }

    public function help()
    {
        return view('help');
    }
}
