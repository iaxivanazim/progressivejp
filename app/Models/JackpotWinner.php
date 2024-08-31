<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotWinner extends Model
{
    use HasFactory;
    protected $fillable = [
        'jackpot_id',
        'game_table_id',
        'table_name',
        'sensor_number',
        'win_amount',
        'is_settled',
    ];

    public function jackpot()
    {
        return $this->belongsTo(Jackpot::class);
    }

    public function gameTable()
    {
        return $this->belongsTo(GameTable::class);
    }
}
