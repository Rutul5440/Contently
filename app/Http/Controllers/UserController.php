<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUser;
use App\Exports\ExportUser;

class UserController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('user.view'), 403);
        $users = User::latest()->paginate(10);
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        abort_if(!auth()->user()->can('user.add'), 403);
        return view('users.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('user.add'), 403);
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        abort_if(!auth()->user()->can('user.update'), 403);
        return view('users.create', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if(!auth()->user()->can('user.update'), 403);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|unique:users,phone,' . $user->id,
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        abort_if(!auth()->user()->can('user.delete'), 403);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function updateRole(Request $request)
    {
        abort_if(!auth()->user()->can('user.update'), 403);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::find($request->user_id);
        $user->syncRoles([$request->role]);

        return response()->json(['success' => true]);
    }

    public function importView(Request $request)
    {
        return view('users.index');
    }

    public function import(Request $request)
    {
        Excel::import(
            new ImportUser,
            $request->file('file')->store('files')
        );
        return redirect()->back();
    }

    public function exportUsers(Request $request)
    {
        return Excel::download(new ExportUser, 'users.xlsx');
    }
}
