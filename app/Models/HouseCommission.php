<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'bet_id',
        'commission_amount',
    ];

    public function bet()
    {
        return $this->belongsTo(Bet::class);
    }
}
