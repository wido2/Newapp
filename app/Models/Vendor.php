<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'npwp',
        'alamat',
        'telepon',
        'fax',
        'email',
        'website',
        'kontak_id',
        'vendor_category_id'
    ];
    public function vendor_category()
    {
        return $this->belongsTo(VendorCategory::class);
    }
    public function kontak()
    {
        return $this->hasMany(Kontak::class);
    }

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }
    public function surat_jalan()
    {
        return $this->hasMany(SuratJalan::class);
    }
    public function harga_barang()
    {
        return $this->hasMany(HargaBarang::class);
    }
}
