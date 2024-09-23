<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RolesExport;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        // Handle search query
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        // Handle search and sort functionality
        $roles = Role::with('permissions')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(20);

        // Handle Excel export
        if ($request->has('export') && $request->export == 'excel') {
            return Excel::download(new RolesExport($roles), 'roles.xlsx');
        }

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'required|array',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id); // Fetch the role by its ID
        $permissions = Permission::all(); // Fetch all permissions
        $selectedPermissions = $role->permissions->pluck('id')->toArray(); // Get the IDs of the associated permissions

        return view('roles.edit', compact('role', 'permissions', 'selectedPermissions'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:roles,name,' . $id, // Ensure the role name is unique except for the current role
            'permissions' => 'sometimes|required|array', // New field for permission selection
            'permissions.*' => 'sometimes|exists:permissions,id', // Ensure each permission ID exists
        ]);

        // Fetch the role by its ID
        $role = Role::findOrFail($id);

        // Update the role with validated data
        $role->update([
            'name' => $validated['name'], // Update the role's name
        ]);

        // Sync selected permissions
        $role->permissions()->sync($validated['permissions']);

        // Redirect back to the roles index with a success message
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
