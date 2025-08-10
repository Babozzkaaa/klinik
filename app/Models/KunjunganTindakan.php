<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunjunganTindakan extends Model
{
    protected $fillable = [
        'kunjungan_id',
        'tindakan_id',
        'jumlah',
        'tarif',
        'subtotal',
        'catatan',
    ];

    protected $casts = [
        'tarif' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class);
    }
}
