<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
         'nomor_po', 
         'nomor_penawaran', 
         'vendor_id', 
         'kontak_id', 
         'paymet_term_id',
         'tanggal_pengiriman', 
         'project_id',
         'project_item_id',
         'total_po', 
         'ppn', 
         'diskon', 
         'total_bayar',
          'biaya_kirim',
          'status', 
          'note'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function kontak()
    {
        return $this->belongsTo(Kontak::class);
    }
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function projectItem()

    {
        return $this->belongsTo(ProjectItem::class);
    }
    public function paymetTerm()
    {
        return $this->belongsTo(PaymetTerm::class);
    }
    
}
