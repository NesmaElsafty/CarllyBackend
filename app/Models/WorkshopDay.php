<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopDay extends Model
{
    use HasFactory;

    protected $table = 'workshop_days';
    protected $guarded = [];

    public function workshop_provider(){
        return $this->belongsTo(WorkshopProvider::class, 'workshop_provider_id');
    }
}
