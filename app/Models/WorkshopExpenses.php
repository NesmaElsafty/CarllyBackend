<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopExpenses extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $hidden = ['updated_at',];

    // public function getImageAttribute($val) {
    //     return asset($val);
    // }

    public function user() {
        return $this->belongsTo(allUsersModel::class,'user_id');
    }
}
