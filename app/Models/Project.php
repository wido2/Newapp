<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
    'nama',
    'customer_id',
    'tanggal_mulai',
    'tanggal_selesai',
    'is_active',
    'status',
    'deskripsi'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function projectItems()
    {
        return $this->hasMany(ProjectItem::class);
    }
    
}
