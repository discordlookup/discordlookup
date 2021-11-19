<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function snowflake($snowflake = '')
    {
        return view('snowflake', ['snowflake' => $snowflake]);
    }

    public function guildlist()
    {
        return view('guildlist');
    }

    /* Invite Resolver */
    public function inviteresolver($code = '')
    {
        return view('inviteresolver', ['code' => $code]);
    }

    public function guildshardcalculator($guildId = '', $totalShards = '')
    {
        return view('guild-shard-calculator', ['guildId' => $guildId, 'totalShards' => $totalShards]);
    }

    public function snowflakedistancecalculator($snowflake1 = '', $snowflake2 = '')
    {
        return view('snowflake-distance-calculator', ['snowflake1' => $snowflake1, 'snowflake2' => $snowflake2]);
    }

    public function help()
    {
        return view('help');
    }
}
