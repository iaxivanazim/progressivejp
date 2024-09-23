<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Handle search and sort inputs
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        // Handle search and sort functionality
        $users = User::with('role')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(20);

        // Handle Excel export
        if ($request->has('export') && $request->export == 'excel') {
            return Excel::download(new UsersExport($users), 'users.xlsx');
        }

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Fetch the user by its ID
        $roles = Role::all(); // Fetch all roles
        // $selectedRoles = $user->roles->pluck('id')->toArray(); // Get the IDs of the associated roles

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|string',
            'pin' => 'required|string',
            'roles' => 'sometimes|required|array', // New field for role selection
            'roles.*' => 'sometimes|exists:roles,id', // Ensure each role ID exists
        ]);

        // Fetch the user by its ID
        $user = User::findOrFail($id);

        // Update the user's non-password fields
        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password); // Hash the password if provided
        }
        $user->update($data);

        // Sync selected roles
        if ($request->has('roles')) {
            $user->roles()->sync($validated['roles']);
        }

        // Redirect back to the users index with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    
    // Toggle the user's status
    $user->status = $user->status === 'Active' ? 'Inactive' : 'Active';
    $user->save();
    
    return redirect()->route('users.index')->with('success', 'User status updated successfully');
}
}
