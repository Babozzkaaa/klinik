<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }


    public function getActionAttribute()
    {
        $parts = explode('.', $this->code);
        return $parts[1] ?? 'general';
    }

    public static function getGroupedPermissions()
    {
        return self::all()->groupBy(function($permission) {
            return $permission->section;
        });
    }

    public static function getCrudPermissions($resource)
    {
        $actions = ['read', 'create', 'update', 'delete'];
        return self::whereIn('code', array_map(function($action) use ($resource) {
            return "{$resource}.{$action}";
        }, $actions))->get();
    }

    public static function generateCrudPermissions($resource, $resourceDisplayName)
    {
        $permissions = [
            ['name' => "Lihat {$resourceDisplayName}", 'code' => "{$resource}.read"],
            ['name' => "Tambah {$resourceDisplayName}", 'code' => "{$resource}.create"],
            ['name' => "Edit {$resourceDisplayName}", 'code' => "{$resource}.update"],
            ['name' => "Hapus {$resourceDisplayName}", 'code' => "{$resource}.delete"],
        ];

        $createdPermissions = [];
        
        foreach ($permissions as $permission) {
            $createdPermission = self::firstOrCreate(
                ['code' => $permission['code']],
                ['name' => $permission['name']]
            );
            $createdPermissions[] = $createdPermission;
        }
        
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        if ($adminRole) {
            $newPermissionIds = collect($createdPermissions)->pluck('id')->toArray();
            $existingPermissionIds = $adminRole->permissions()->pluck('permissions.id')->toArray();
            $permissionsToAdd = array_diff($newPermissionIds, $existingPermissionIds);
            
            if (!empty($permissionsToAdd)) {
                $adminRole->permissions()->attach($permissionsToAdd);
            }
        }
    }
}
