<?php

namespace App\Models;

use App\User;
use Ramsey\Uuid\Uuid;
use App\Models\LeagueMember;
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

    public function leagueMember()
    {
        return $this->belongsTo(LeagueMember::class, 'user_id', 'id');
    }

    public function Player() {
    	return $this->belongsTo(TournamentPlayer::class, 'player_id', 'id');
    }

    // Attributes
    public function getUserNameAttribute()
    {
    	return $this->User->name;
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
