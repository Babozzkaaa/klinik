<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        if ($sortBy == 'roles_count') {
            $query->withCount('roles')->orderBy('roles_count', $sortDirection);
        } elseif ($sortBy == 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } elseif ($sortBy == 'code') {
            $query->orderBy('code', $sortDirection);
        } else {
            $query->orderBy('name', $sortDirection);
        }

        $permissions = $query->paginate(10)->appends($request->query());
        
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        if ($request->has('generate_crud') && $request->generate_crud) {
            $validator = Validator::make($request->all(), [
                'resource_code' => 'required|string|max:50|regex:/^[a-z_-]+$/',
                'resource_name' => 'required|string|max:100'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $existingPermissions = Permission::where('code', 'like', $request->resource_code . '.%')->count();
            if ($existingPermissions > 0) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['resource_code' => 'CRUD permissions untuk resource ini sudah ada.']);
            }

            Permission::generateCrudPermissions($request->resource_code, $request->resource_name);

            return redirect()->route('admin.permissions.index')
                ->with('success', "4 CRUD permissions untuk {$request->resource_name} berhasil ditambahkan dan diberikan ke role admin");
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:permissions'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $permission = Permission::create($validator->validated());
            
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole && !$adminRole->permissions()->where('permissions.id', $permission->id)->exists()) {
                $adminRole->permissions()->attach($permission->id);
            }

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission berhasil ditambahkan dan otomatis diberikan ke role admin');
        }
    }

    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:permissions,code,' . $permission->id
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $permission->update($validator->validated());

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil diperbarui');
    }

    public function destroy(Permission $permission)
    {
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Permission tidak dapat dihapus karena masih digunakan oleh role');
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil dihapus');
    }
}
