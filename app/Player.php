<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($player) {
            $player->teams()->detach();
        });
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

}
