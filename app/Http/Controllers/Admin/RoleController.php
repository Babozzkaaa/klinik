<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::with('permissions', 'users');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        if ($sortBy == 'users_count') {
            $query->withCount('users')->orderBy('users_count', $sortDirection);
        } elseif ($sortBy == 'permissions_count') {
            $query->withCount('permissions')->orderBy('permissions_count', $sortDirection);
        } elseif ($sortBy == 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $query->orderBy('name', $sortDirection);
        }

        $roles = $query->paginate(10)->appends($request->query());
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $groupedPermissions = Permission::getGroupedPermissions();
        return view('admin.roles.create', compact('groupedPermissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $role = Role::create([
            'name' => $validator->validated()['name']
        ]);
        if (isset($validator->validated()['permissions'])) {
            $role->permissions()->sync($validator->validated()['permissions']);
        }
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $groupedPermissions = Permission::getGroupedPermissions();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $role->update([
            'name' => $validator->validated()['name']
        ]);
        $role->permissions()->sync($validator->validated()['permissions'] ?? []);
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh user');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}
