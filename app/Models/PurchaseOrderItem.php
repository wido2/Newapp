<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'produk_id',
        'quantity',
        'satuan_id',
        'price',
        'discount',
        'pajak_id',
        'subtotal',
        'notes'

    ];
    public function pajak()
    {
        return $this->belongsTo(Pajak::class);
    }
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
