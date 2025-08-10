<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role && strtolower($this->role->name) === 'admin';
    }

    public function hasPermission($code)
    {
        // Cek status user dulu - hanya user aktif yang bisa mengakses
        if (!$this->isAktif()) {
            return false;
        }

        // Admin selalu memiliki semua permission
        if ($this->isAdmin()) {
            return true;
        }

        // Cek permission dari role
        return $this->role
            && $this->role->permissions()->where('code', $code)->exists();
    }
    public function hasRole($roleName): bool
    {
        return $this->role && strtolower($this->role->name) === strtolower($roleName);
    }

    public function getAllPermissions()
    {
        // Admin gets all permissions
        if ($this->isAdmin()) {
            return \App\Models\Permission::all();
        }

        $permissions = collect();
        
        // Get permissions from role
        if ($this->role) {
            $permissions = $permissions->merge($this->role->permissions);
        }
        
        return $permissions->unique('id');
    }

    // Status methods
    public function isAktif(): bool
    {
        return $this->status === true;
    }

    public function isTidakAktif(): bool
    {
        return $this->status === false;
    }
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }
}
