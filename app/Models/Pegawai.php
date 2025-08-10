<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'spesialisasi',
        'jenis_kelamin',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'user_id',
    ];
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function isAktif(): bool
    {
        return $this->user && $this->user->status == 1;
    }

    public function isDokter(): bool
    {
        return strtolower($this->jabatan) === 'dokter';
    }

    public function isPerawat(): bool
    {
        return strtolower($this->jabatan) === 'perawat';
    }

}
