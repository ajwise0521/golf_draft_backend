<?php

namespace App\Models;

use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class DraftPick extends Model
{
	protected $table = 'draft_picks';
    protected $keyType = 'string';
    public $incrementing = false;
    public $appends = ['userName'];
    
    // Relationships
    public function User() 
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Player() {
    	return $this->belongsTo(TournamentPlayer::class, 'player_id', 'id');
    }

    // Attributes
    public function getUserNameAttribute()
    {
    	return User::where('api_token', $this->user_id)->first()->name;
    }

    public function Draft()
    {
        return $this->belongsTo(Draft::class, 'draft_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }
}
