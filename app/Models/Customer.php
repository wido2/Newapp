<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable=[
        'nama', 'deskripsi','npwp'
    ];

    public function kontak()
    {
        return $this->hasMany(Kontak::class);
    }
    public function address()
    {
        return $this->hasMany(Address::class);
    }
    public function project()
    {
        return $this->hasMany(Project::class);
    }

}
