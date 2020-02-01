<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($team) {
            $team->players()->detach();
        });
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }
}
