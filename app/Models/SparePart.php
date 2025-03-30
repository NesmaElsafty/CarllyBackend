<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;
    protected $casts = [
        'car_model' => 'array',
    ];
    protected $guarded = [];

    public function getImageAttribute($val) {
        return asset($val);
    }

    public function images() {
        return $this->hasMany(SparePartImage::class);
    }

    public function user() {
        return $this->belongsTo(allUsersModel::class,'user_id');
    }

    public function category() {
        return $this->belongsTo(SparepartCategory::class,'category_id');
    }
}   