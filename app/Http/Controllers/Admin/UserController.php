<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect('/admin/users');
    }

    public function editRole($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all();

    return view('admin.users.role', compact('user','roles'));
}

public function updateRole(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->role_id = $request->role_id;
    $user->save();

    return back()->with('success', 'Role updated');
}
}
