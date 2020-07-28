<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Models\DraftConstraint;
use Illuminate\Database\Eloquent\Model;

class TournamentPlayer extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'tournament_players';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }

    public function getDraftConstraints($draft, $user)
    {
        $playerRanks = TournamentPlayer::select('rank')->whereIn('id', 
            DraftPick::where('user_id' ,$user->id)
                ->where('draft_id', $draft->id)
                ->whereNotNull('player_id')
                ->select('player_id')
                ->get()
                ->makeHidden(['userName'])
                ->toArray())
            ->orderBy('rank')
            ->get();
            
        $constraints = DraftConstraint::where('draft_id', $draft->id)
            ->get();
        $passedConstraints = [];
        foreach($constraints as $constraint) {
            $playerCount = 0;
            foreach($playerRanks as $rank) {
                if($rank['rank'] >= $constraint->min_rank && $rank['rank'] <= $constraint->max_rank) {
                    $playerCount++;
                }
            }
            if($playerCount < $constraint->player_count) {
                array_push($passedConstraints, $constraint);

            }
        }
        $constraintCount = 0;
        return $passedConstraints;
        foreach($passedConstraints as $constraint) {

            $query->where(function($query) use ($constraint){
                return $query->where('rank', '>=', $constraint->min_rank)
                    ->where('rank', '<=', $constraint->max_rank);
            });
        }

        return $query;
    }

    // App\Models\TournamentPlayer::where(function($query) { 
    //     return $query->where('rank', '>=', 1)
    //         ->where('rank', '<=', 20)
    //         ->orWhere(function($query) {
    //             return $query->where('rank', '>=', 51)
    //             ->where('rank', '<=', 75)
    //             ->get();
    //         })->get();
    //     })->get();
}
