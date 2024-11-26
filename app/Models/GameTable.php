<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTable extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_players', 'chip_value'];
    // Relationship with Bet
    public function bets()
    {
        return $this->hasMany(Bet::class);
    }

    // Many-to-many relationship with Jackpot
    public function jackpots()
    {
        return $this->belongsToMany(Jackpot::class, 'game_table_jackpot');
    }

    public function hands()
    {
        return $this->belongsToMany(Hand::class, 'game_table_hand');
    }
}
