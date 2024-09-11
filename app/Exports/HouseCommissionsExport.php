<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HouseCommissionsExport implements FromCollection, WithHeadings
{
    protected $commissions;

    public function __construct($commissions)
    {
        $this->commissions = $commissions;
    }

    public function collection()
    {
        return $this->commissions->map(function ($commission) {
            return [
                $commission->id,
                $commission->bet_id,
                $commission->commission_amount,
                $commission->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Bet ID', 'Commission Amount', 'Created At'];
    }
}
