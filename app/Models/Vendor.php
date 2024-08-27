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
        'kontak_id'
    ];
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
}
