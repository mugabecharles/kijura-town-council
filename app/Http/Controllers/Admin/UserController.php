<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.form', ['user' => new User, 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed',
            'phone'     => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:255',
            'department'=> 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'roles'     => 'nullable|array',
            'roles.*'   => 'exists:roles,name',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);
        if ($request->filled('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        AuditLog::record('create', "Created user: {$user->name}", $user);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => "required|email|unique:users,email,{$user->id}",
            'password'  => 'nullable|min:8|confirmed',
            'phone'     => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:255',
            'department'=> 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'roles'     => 'nullable|array',
            'roles.*'   => 'exists:roles,name',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        $user->syncRoles($request->input('roles', []));

        AuditLog::record('update', "Updated user: {$user->name}", $user);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        AuditLog::record('delete', "Deleted user: {$user->name}", $user);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
