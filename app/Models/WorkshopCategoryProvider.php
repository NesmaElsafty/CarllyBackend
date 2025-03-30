<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopCategoryProvider extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'workshop_category_provider';

    public function provider()
    {
        return $this->belongsTo(WorkshopProvider::class, 'provider_id');
    }

    public function category()
    {
        return $this->belongsTo(WorkshopCategory::class, 'category_id');
    }
}
