<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $table = 'leagues';
    protected $keyType = 'string';
    public $incrementing = false;
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }

    public function Draft()
    {
        return $this->hasOne(Draft::class, 'league_id', 'id');
    }
}
