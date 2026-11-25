<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/** Admin / staff login accounts (admin only). */
class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:user,email'],
            'role'     => ['required', Rule::in(array_keys(User::ROLES))],
            'password' => ['required', 'string', 'min:6'],
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;
        User::create($data);

        return back()->with('success', 'User account created.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', Rule::unique('user', 'email')->ignore($user->id)],
            'role'     => ['required', Rule::in(array_keys(User::ROLES))],
            'password' => ['nullable', 'string', 'min:6'],
        ]);
        $data['status'] = $request->boolean('status') ? 1 : 0;

        if ($user->id === $request->user()->id && ($data['role'] !== 'admin' || ! $data['status'])) {
            return back()->with('error', 'You cannot remove your own admin access or deactivate yourself.');
        }

        if (blank($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);

        return back()->with('success', 'User account updated.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'At least one admin account must remain.');
        }
        $user->delete();

        return back()->with('success', 'User account deleted.');
    }
}
