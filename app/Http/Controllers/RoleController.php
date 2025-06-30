<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->get();

        $permissions = Permission::all();

        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }
        return view('settings.roles.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        return view('settings.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return redirect()->route('settings.roles.index')->with('success', 'Role created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Role $role)
    {
        return view('settings.roles.create', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|unique:roles,name,' .$role->id]);
        $role->update(['name' => $request->name]);
        return redirect()->route('settings.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role deleted!');
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array|nullable',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'Permissions updated for role: ' . ucfirst($role->name));
    }
}
