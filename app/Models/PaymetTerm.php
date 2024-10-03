<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymetTerm extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'deskripsi',
        'day'
    ];
    public function purchaseOrder()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
