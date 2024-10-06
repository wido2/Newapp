<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'kode',
        'persentase',
        'is_active'];
    public function purchaseOrderItem()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    
}
