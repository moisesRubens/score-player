<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerPerformance extends Model
{
    protected $table = 'players_performance';

    protected $fillable = [
        'player_id',
        'match_id',
        'map',
        'individual_kills',
        'individual_survive'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function battle() 
    {
        return $this->belongsTo(Battle::class);
    }

}
