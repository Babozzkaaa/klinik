<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_telp',
        'alergi',
        'riwayat_penyakit',
        'gol_darah',
        'pekerjaan',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}
