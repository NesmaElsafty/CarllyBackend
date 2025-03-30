<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;

class WorkshopProvider extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $guarded = [];


    protected $hidden = [
        "password",
    ];


    // public function getWorkshopLogoAttribute($val)
    // {
    //     return asset($val);
    // }


    public function categories()
    {
        return $this->belongsToMany(WorkshopCategory::class, 'workshop_category_provider');
    }

    public function brands()
    {
        return $this->belongsToMany(CarBrand::class, 'car_brand_workshop_provider');
    }

    public function user()
    {
        return $this->belongsTo(allUsersModel::class);
    }

    public function days()
    {
        return $this->hasMany(WorkshopDay::class, 'workshop_provider_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'workshop_provider_id');
    }
}