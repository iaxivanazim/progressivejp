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
}
