<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunjunganObat extends Model
{
    protected $fillable = [
        'kunjungan_id',
        'obat_id',
        'jumlah',
        'tarif',
        'subtotal',
        'instruksi',
    ];

    protected $casts = [
        'tarif' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
