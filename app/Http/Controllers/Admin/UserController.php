<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        if ($sortBy == 'role_name') {
            $query->join('roles', 'users.role_id', '=', 'roles.id')
                  ->orderBy('roles.name', $sortDirection)
                  ->select('users.*');
        } elseif ($sortBy == 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } elseif ($sortBy == 'email') {
            $query->orderBy('email', $sortDirection);
        } else {
            $query->orderBy('name', $sortDirection);
        }

        $users = $query->paginate(10)->appends($request->query());
        $roles = Role::all();
        $showPagination = $users->total() > 10;
        
        return view('admin.users.index', compact('users', 'roles', 'showPagination'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'status' => $data['status'],
        ]);
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $user->load('role.permissions');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($this->isAdminUser($user) && !$this->isCurrentUserAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit user admin');
        }

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($this->isAdminUser($user) && !$this->isCurrentUserAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit user admin');
        }

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|boolean'
        ];

        if ($user->id === auth()->id()) {
            $validationRules['password'] = 'nullable|string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];
        if ($user->id !== auth()->id()) {
            $updateData['role_id'] = $data['role_id'];
            $updateData['status'] = $data['status'];
        }
        if ($user->id === auth()->id() && isset($data['password']) && $data['password']) {
            $updateData['password'] = Hash::make($data['password']);
        }
        $user->update($updateData);
        $message = 'User berhasil diperbarui';
        if ($user->id === auth()->id()) {
            $message .= ' (Role dan status tidak dapat diubah untuk akun sendiri)';
        } else {
            $message .= ' (Password tidak dapat diubah untuk akun orang lain)';
        }
        return redirect()->route('admin.users.index')
            ->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    private function isAdminUser(User $user)
    {
        return $user->role && strtolower($user->role->name) === 'admin';
    }

    private function isCurrentUserAdmin()
    {
        $currentUser = auth()->user();
        return $currentUser && $this->isAdminUser($currentUser);
    }
}
