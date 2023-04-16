<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function players()
    {
        return $this->hasMany(Player::class, "player_id");
    }

    public function games()
    {
        return $this->hasMany(Game::class, "game_id");
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
