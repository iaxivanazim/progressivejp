<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RolesExport implements FromCollection, WithHeadings
{
    public $roles;

    public function __construct($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->roles->map(function ($role) {
            $permissions = $role->permissions->pluck('name')->implode(', ');
            return [
                'Name' => $role->name,
                'Permissions' => $permissions,
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Permissions'];
    }
}
