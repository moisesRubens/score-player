<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerPerformance extends Model
{
    protected $table = 'players_performance';

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
