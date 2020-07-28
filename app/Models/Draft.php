<?php

namespace App\Models;

use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Draft extends Model
{

    protected $keyType = 'string';
    public $incrementing = false;
    public $with = ['Tournament', 'League'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }

// Relationships
    public function League()
    {
    	return $this->belongsTo(League::class, 'league_id', 'id');
    }

    public function Tournament()
    {
    	return $this->belongsTo(Tournament::class, 'tournament_id', 'id');
    }

    public function LeagueMembers()
    {
    	return $this->hasMany(LeagueMember::class, 'league_id', 'league_id');
    }

// Scopes
    public function scopeAvailable($query) {
    	$query->whereIn('status', ['Active', 'Created']);
    }
}
