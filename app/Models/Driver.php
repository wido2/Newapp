<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'kendaraan_id',
        'telepon',
        'ktp',
        'sim',
        'email',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'alamat',
        'scan_ktp'
    ];
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
    public function surat_jalan()
    {
        return $this->hasMany(SuratJalan::class);
    }

}
