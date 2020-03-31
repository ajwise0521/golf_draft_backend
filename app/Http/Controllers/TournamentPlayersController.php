<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class TournamentPlayersController extends Controller
{
    public function getPlayersByTournament($tournamentId) {
    	return response()->json(Player::get());

    }
}
