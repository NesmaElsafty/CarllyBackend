<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "banners";
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
