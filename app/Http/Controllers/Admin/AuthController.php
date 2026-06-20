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

        if (!$user->role) {
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

public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $link = url('/reset-password/'.$token.'?email='.$user->email);

        Mail::raw("Reset Password Link: ".$link, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Reset Password');
        });

        return back()->with('success', 'Reset link sent successfully.');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->with('error', 'Invalid token');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('success', 'Password reset successfully');
    }
}
