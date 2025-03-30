<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }

    public function getLimitsAttribute($val)
    {
        return json_decode($val);
    }

    public function users(){
        return $this->hasMany(allUsersModel::class);
    }
    
}
