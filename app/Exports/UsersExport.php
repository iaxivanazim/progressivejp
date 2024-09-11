<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users->map(function ($user) {
            return [
                'Name' => $user->name,
                'Username' => $user->username,
                'Status' => $user->status,
                'Role' => $user->role->name ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Username', 'Status', 'Role'];
    }
}

