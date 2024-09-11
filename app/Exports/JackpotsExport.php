<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JackpotsExport implements FromCollection, WithHeadings
{
    protected $jackpots;

    public function __construct($jackpots)
    {
        $this->jackpots = $jackpots;
    }

    public function collection()
    {
        return $this->jackpots->map(function ($jackpot) {
            return [
                $jackpot->id,
                $jackpot->name,
                $jackpot->seed_amount,
                $jackpot->current_amount,
                $jackpot->contribution_percentage,
                $jackpot->is_global ? 'Global' : 'Table-specific',
                $jackpot->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Seed Amount', 'Current Amount', 'Contribution Percentage', 'Type', 'Created At'];
    }
}
