<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaBarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'produk_id',
        'vendor_id',
        'harga_kemarin',
        'harga_terbaru',
        'tahun_kemarin',
        'tahun_terbaru',
        'perubahan',
        'status_perubahan',
        'keterangan'
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    
}
