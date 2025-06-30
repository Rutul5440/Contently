<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function userManagement()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('settings.user-management', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role assigned successfully.');
    }
}
