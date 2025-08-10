<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'didaftarkan_oleh',
        'tanggal_kunjungan',
        'jenis_kunjungan', //umum, rujukan, kontrol, rutin, vaksinasi, darurat
        'keluhan',
        'diagnosa',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'datetime',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_id');
    }

    public function pendaftar()
    {
        return $this->belongsTo(Pegawai::class, 'didaftarkan_oleh');
    }

    public function pegawai() 
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function kunjunganTindakan()
    {
        return $this->hasMany(KunjunganTindakan::class);
    }

    public function kunjunganObat()
    {
        return $this->hasMany(KunjunganObat::class);
    }
}
