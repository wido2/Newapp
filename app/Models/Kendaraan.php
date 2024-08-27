<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id','nama',
         'nomor_polisi',
        'jenis_kendaraan',
        'merk',
        'tahun_pembuatan',
        'warna',
        'nomor_rangka',
        'nomor_mesin',
        'nomor_stnk',
        'nomor_bpkb',
        'tanggal_stnk',
        'tanggal_bpkb',
        'scan_stnk',
        'scan_bpkb',
        'foto_kendaraan',
    ];
    protected $casts =[
        'scan_stnk' => 'array',
        'scan_bpkb' => 'array',
        'foto_kendaraan' => 'array',
    ];
    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function surat_jalan()
    {
        return $this->hasMany(SuratJalan::class);
    }

}

