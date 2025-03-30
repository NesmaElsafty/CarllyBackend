<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ModelYear extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }
    public function model() {
        return $this->belongsTo(BrandModel::class,'model_id');
    }
}
