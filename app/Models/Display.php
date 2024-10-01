<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Display extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'jackpot_ids', 'hand_ids'];

    // Accessors for decoding the JSON fields
    public function getJackpotIdsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getHandIdsAttribute($value)
    {
        return json_decode($value, true);
    }

    // protected $casts = [
    //     'jackpot_ids' => 'array',  // This will ensure jackpot_ids are treated as an array automatically
    //     'hand_ids' => 'array',
    // ];

    public function jackpots()
    {
        return Jackpot::whereIn('id', $this->jackpot_ids)->get();
    }

    // Relationship with Hand
    public function hands()
    {
        return Hand::whereIn('id', $this->hand_ids)->get();
    }
}
