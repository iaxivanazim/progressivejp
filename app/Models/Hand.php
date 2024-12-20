<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deduction_type',
        'deduction_value',
        'float', // Add the float column to the fillable fields
    ];

    public function calculateDeduction($jackpotAmount)
    {
        if ($this->deduction_type == 'percentage') {
            return ($this->deduction_value / 100) * $jackpotAmount;
        } elseif ($this->deduction_type == 'fixed') {
            return $this->deduction_value;
        }

        return 0; // Default, if no valid deduction type is set
    }

    public function gameTables()
    {
        return $this->belongsToMany(GameTable::class, 'game_table_hand');
    }
}
