<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::all(); // Fetch all roles
    return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // Validate the incoming request data
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role_id' => ['required', 'exists:roles,id'],  // Ensure the role exists
        'status' => ['required', 'string', 'max:255'],  // Assuming status is a required field
        'pin' => ['required', 'string', 'max:4'],       // Assuming pin is required and has max length of 4
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'role_id' => $request->role_id,  // Assign the role ID
        'status' => $request->status,    // Assign the status
        'pin' => $request->pin,          // Assign the pin
    ]);

    // Fire the Registered event
    event(new Registered($user));

    // Log the user in
    Auth::login($user);

    // Redirect to the dashboard
    return redirect(route('dashboard', absolute: false));
}
}
