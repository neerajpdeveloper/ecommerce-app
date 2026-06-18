<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        $user->load('role');

        if (!$user->role || $user->role->slug !== 'admin') {
            Auth::logout();
            return back()->withErrors(['error' => 'Access denied']);
        }

        return redirect('/admin/dashboard');
    }

    return back()->withErrors(['error' => 'Invalid credentials']);
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
    ]);

    // 🔥 get admin role
    $role = Role::where('slug', 'admin')->first();

    if (!$role) {
        return back()->withErrors(['error' => 'Admin role not found']);
    }

    // 🔥 create user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $role->id
    ]);

    // 🔥 auto login
    Auth::login($user);

    return redirect('/admin/dashboard');
}

public function showLogin()
{
    return view('admin.auth.login');
}

public function showRegister()
{
    return view('admin.auth.register');
}

public function logout()
{
    auth()->logout();
    return redirect('/admin/login');
}
}
