<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrandWorkshopProvider extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'car_brand_workshop_provider';

    public function car_brand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    public function workshop_provider()
    {
        return $this->belongsTo(WorkshopProvider::class);
    }
}
