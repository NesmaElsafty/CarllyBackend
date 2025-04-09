<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SparepartCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('d M, Y H:i');
    }
    
    public function getImageAttribute($val) {
        return ($val)?asset($val):asset('icon/sparepart.jpg');
    }

    public function spareParts()
{
    return $this->belongsToMany(SparePart::class, 'spare_part_sparepart_category', 'sparepart_category_id', 'spare_part_id');
}
}
