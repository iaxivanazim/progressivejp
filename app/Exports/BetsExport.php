<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BetsExport implements FromCollection, WithHeadings
{
    protected $bets;

    public function __construct($bets)
    {
        $this->bets = $bets;
    }

    public function collection()
    {
        return $this->bets->map(function ($bet) {
            return [
                'ID' => $bet->id,
                'Game Table' => $bet->gameTable->name ?? 'N/A',
                'Sensor Data' => $bet->sensor_data,
                'Total Bet Amount' => $bet->total_bet_amount,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Game Table', 'Sensor Data', 'Total Bet Amount'];
    }
}
