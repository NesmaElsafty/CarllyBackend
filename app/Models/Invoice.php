<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['updated_at',];

    // public function getImageAttribute($val) {
    //     return asset($val);
    // }
    public function customer() {
        return $this->belongsTo(WorkshopCustomer::class,'customer_id');
    }
    public function workshop() {
        return $this->belongsTo(allUsersModel::class,'workshop_id');
    }
    public function invoiceItems() {
        return $this->hasMany(InvoiceItem::class);
    }
  
}
