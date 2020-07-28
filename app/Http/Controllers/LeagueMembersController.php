<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\LeagueMember;
use Illuminate\Http\Request;

class LeagueMembersController extends Controller
{
    function getLeagueMembers(League $league) {
    	return response()->json(LeagueMember::where('league_id', $league->id)->get());
    }
}
