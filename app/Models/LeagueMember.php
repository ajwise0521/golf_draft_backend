<?php

namespace App\Models;

use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class LeagueMember extends Model
{
	protected $table = 'league_members';
    protected $keyType = 'string';
    protected $with = ['League', 'User'];
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }

    public function League() 
    {
    	return $this->belongsTo(League::class, 'league_id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
