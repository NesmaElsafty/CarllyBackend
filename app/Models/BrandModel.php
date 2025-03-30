<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BrandModel extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }

    public function brand() {
        return $this->belongsTo(CarBrand::class,'brand_id');
    }
}
