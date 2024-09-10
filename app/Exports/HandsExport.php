<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HandsExport implements FromCollection, WithHeadings
{
    protected $hands;

    public function __construct($hands)
    {
        $this->hands = $hands;
    }

    public function collection()
    {
        return $this->hands->map(function ($hand) {
            return [
                $hand->id,
                $hand->name,
                $hand->deduction_type,
                $hand->deduction_value,
                $hand->created_at,
                $hand->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Deduction Type', 'Deduction Value', 'Created At', 'Updated At',];
    }
}
