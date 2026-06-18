<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        Role::create([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        return back();
    }
    public function permissions($roleId)
{
    $role = Role::with('permissions')->findOrFail($roleId);
    $permissions = Permission::all();

    return view('admin.roles.permissions', compact('role', 'permissions'));
}

public function assignPermissions(Request $request, $roleId)
{
    $role = Role::findOrFail($roleId);

    $role->permissions()->sync($request->permissions ?? []);

    return back()->with('success', 'Permissions updated');
}
}
