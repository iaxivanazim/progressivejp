<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jackpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contribution_percentage',
        'current_amount',
        'seed_amount',
        'trigger_type',
        'max_trigger_amount',
        'is_global',
        // other fields
    ];

    // Relationships can be added here if needed
    // Many-to-many relationship with GameTable
    public function gameTables()
    {
        return $this->belongsToMany(GameTable::class, 'game_table_jackpot');
    }
}
