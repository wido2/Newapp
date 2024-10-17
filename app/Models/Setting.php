<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
        'logo',
        'npwp',
        'website',
        'alamat_pengiriman',
        'nomor_telepon_penerima',
        'nama_penerima',
        'nama_approver'
    ];
    
    protected $casts=['logo'];


}
