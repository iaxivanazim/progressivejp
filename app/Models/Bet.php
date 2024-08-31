<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_table_id',
        'sensor_data',
        'total_bet_amount',
        'amount',
    ];

    // Relationship with GameTable
    public function gameTable()
    {
        return $this->belongsTo(GameTable::class);
    }
}
