<?php

namespace App\Http\Controllers;

use App\User; 
use App\Models\Draft;
use App\Models\DraftPick;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\TournamentPlayer as Player;

class TournamentPlayersController extends Controller
{
    public function getAvailablePlayers(Draft $draft, User $user) 
    {

        $constraints =  (new Player())->getDraftConstraints($draft, $user);
        // attempt to merge the arrays usig the above constraints and the below query
        $players = NULL;

        foreach($constraints as $constraint) {
        	$tempPlayers = Player::whereNotIn('id', DraftPick::select('player_id')
        			->whereNotNull('player_id')
        			->where('draft_id', $draft->id)
        			->get()
                    ->makeHidden(['userName'])
        			->toArray())
        		->where('tournament_id', $draft->tournament_id)
                ->where(function($query) use ($constraint) {
                    return $query->where('rank', '>=', $constraint->min_rank)
                        ->where('rank', '<=', $constraint->max_rank)->get();
                })
                ->orderBy('rank')
                ->get();
                \Log::debug('players', (array)$tempPlayers);
                if($players == NULL) {
                    $players = $tempPlayers;
                } else {
                    $players = $players->merge($tempPlayers);
                }
        }
        return $players;
    }
}

