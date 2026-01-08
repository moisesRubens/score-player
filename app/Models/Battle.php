<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $table = 'matches';
    protected $fillable = [
        'score',
        'placing',
        'map',
        'survive_time',
        'total_kills'
    ];
}