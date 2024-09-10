<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GameTablesExport implements FromCollection, WithHeadings
{
    protected $gameTables;

    public function __construct($gameTables)
    {
        $this->gameTables = $gameTables;
    }

    public function collection()
    {
        return $this->gameTables->map(function ($gameTable) {
            return [
                $gameTable->id,
                $gameTable->name,
                $gameTable->max_players,
                $gameTable->chip_value,
                $gameTable->created_at,
                $gameTable->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Max Players',
            'Chip Value',
            'Created At',
            'Updated At',
        ];
    }
}
