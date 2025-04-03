<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class carListingModel extends Model
{
    use HasFactory;
    protected $table = 'carlisting';
    protected $appends = ['img1','img2','img3','img4','img5'];
    protected $guarded=[];

   

    public function getImg1Attribute() {
        return asset($this->listing_img1);
    }
    public function getImg2Attribute() {
        return asset($this->listing_img2);
    }
    public function getImg3Attribute() {
        return asset($this->listing_img3);
    }
    public function getImg4Attribute() {
        return asset($this->listing_img4);
    }
    public function getImg5Attribute() {
        return asset($this->listing_img5);
    }

    public function user() {
        return $this->belongsTo(allUsersModel::class,'user_id');
    }

    public function images(){
        return $this->hasMany(Image::class,'carlisting_id');
    }
    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }
}