<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }

    public function getImageAttribute($val)
    {
        return ($val) ? asset($val) : asset('icon/workshop.jpg');
    }

    public function providers()
    {
        return $this->belongsToMany(WorkshopProvider::class, 'workshop_category_provider');
    }
}
