<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'nama_obat',
        'kode_obat',
        'jenis_obat',
        'satuan',
        'harga',
        'stok',
        'tanggal_kadaluarsa',
    ];
}
