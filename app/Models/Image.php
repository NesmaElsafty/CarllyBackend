<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'images';
    
    public function workshop() {
        return $this->belongsTo(WorkshopProvider::class,'workshop_provider_id');
    }
}
