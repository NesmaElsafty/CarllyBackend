<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [];
    protected $table = "ads";

    public function user(){
        return $this->belongsTo(allUsersModel::class, 'user_id');
    }

    public function brand(){
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }
}
