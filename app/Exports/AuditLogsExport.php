<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuditLogsExport implements FromCollection, WithHeadings
{
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        return $this->logs->map(function ($log) {
            return [
                'User' => $log->user ? $log->user->name : 'Guest',
                'Event' => $log->event_type,
                'Details' => $log->details,
                'IP Address' => $log->ip_address,
                'Date' => $log->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ['User', 'Event', 'Details', 'IP Address', 'Date'];
    }
}

