<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'kunjungan_id',
        'kasir_id',
        'no_pembayaran',
        'total_tagihan',
        'jumlah_dibayar',
        'kembalian',
        'catatan',
        'status',
        'tanggal_pembayaran',
        'metode_pembayaran',
    ];

    protected $casts = [
        'total_tagihan' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
        'tanggal_pembayaran' => 'datetime',
    ];

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function kasir(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kasir_id');
    }

    public static function generateNomorPembayaran(): string
    {
        $lastPembayaran = self::latest('id')->first();
        $nextId = $lastPembayaran ? $lastPembayaran->id + 1 : 1;
        $tahun = now()->format('y'); 
        $bulan = now()->format('m'); 
        $id = str_pad($nextId, 5, '0', STR_PAD_LEFT);

        return "{$tahun}{$bulan}{$id}";
    }
}
