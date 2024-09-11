<?php

namespace App\Exports;

use App\Models\JackpotWinner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JackpotWinnersExport implements FromCollection, WithHeadings
{
    public $winners;

    public function __construct($winners)
    {
        $this->winners = $winners;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->winners->map(function ($winner) {
            return [
                'Jackpot' => $winner->jackpot->name,
                'Game Table' => $winner->gameTable->name,
                'Table Name' => $winner->table_name,
                'Sensor Number' => $winner->sensor_number,
                'Win Amount' => $winner->win_amount,
                'Is Settled' => $winner->is_settled ? 'Yes' : 'No',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Jackpot',
            'Game Table',
            'Table Name',
            'Sensor Number',
            'Win Amount',
            'Is Settled',
        ];
    }
}
