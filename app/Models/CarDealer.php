<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CarDealer extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $table="dealers";

    protected $hidden=[
        "password",
    ];


    public function getCompanyImgAttribute($val)
    {
        return asset($val);
    }

    public function dealer() {
        return $this->belongsTo(allUsersModel::class,'user_id');
    }
 
}
