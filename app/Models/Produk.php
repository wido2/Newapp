<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama', 'satuan_id','kategori_id','deskripsi','stok','harga_beli','pajak_id','is_active'
    ];
    public function pajak()
    {
        return $this->belongsTo(Pajak::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
    public function harga_barang()
    {
        return $this->hasMany(HargaBarang::class);
    }
    public function purchase()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
    

}
