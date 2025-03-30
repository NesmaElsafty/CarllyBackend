<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['updated_at','sender_id','reciever_id'];

    // public function getImageAttribute($val) {
    //     return asset($val);
    // }

    public function sender() {
        return $this->belongsTo(allUsersModel::class,'sender_id');
    }

    public function reciever() {
        return $this->belongsTo(allUsersModel::class,'reciever_id');
    }

}
