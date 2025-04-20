<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class allUsersModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'allusers';
    protected $guarded = [];
    protected $hidden = ['password'];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];
    
    public function getImageAttribute($val) {
        return asset($val);
    }

    public function dealer() {
        return $this->hasOne(CarDealer::class,'user_id');
    }

    public function workshop_provider() {
        return $this->hasOne(WorkshopProvider::class,'user_id');
    }

    public function cars() {
        return $this->hasMany(carListingModel::class,'user_id');
    }

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }

    public function ads(){
        return $this->hasMany(Ad::class,'brand_id');
    }

    public function package(){
        return $this->belongsTo(Package::class,'package_id');
    }

    public function subscriptions()
{
    return $this->hasMany(\App\Models\UserPackageSubscription::class, 'user_id');
}

public function currentSubscription()
{
    return $this->hasOne(UserPackageSubscription::class, 'user_id')
        ->where('status', 'active')
        ->latestOfMany('starts_at');
}
}