<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CarBrand extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table = 'car_brands';

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }


    public function providers()
    {
        return $this->belongsToMany(WorkshopProvider::class, 'car_brand_workshop_providers');
    }

    public function ads(){
        return $this->hasMany(Ad::class,'brand_id');
    }
 
}
