<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        return view('home');
    }

    /* Snowflake */
    public function snowflake($snowflake = '')
    {
        return view('snowflake-decoder', ['snowflake' => $snowflake]);
    }

    public function userlookup($snowflake = '')
    {
        return view('user-lookup', ['snowflake' => $snowflake]);
    }

    public function guildlookup($snowflake = '')
    {
        return view('guild-lookup', ['snowflake' => $snowflake]);
    }

    public function applicationlookup($snowflake = '')
    {
        return view('application-lookup', ['snowflake' => $snowflake]);
    }

    public function snowflakedistancecalculator($snowflake1 = '', $snowflake2 = '')
    {
        return view('snowflake-distance-calculator', ['snowflake1' => $snowflake1, 'snowflake2' => $snowflake2]);
    }

    public function guildlist()
    {
        return view('guildlist');
    }

    /* Invite Resolver */
    public function inviteresolver($code = '', $eventId = '')
    {
        return view('inviteresolver', ['code' => $code, 'eventId' => $eventId]);
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
