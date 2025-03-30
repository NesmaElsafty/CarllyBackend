<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carDealersModel extends Model
{
    use HasFactory;
    protected $table = 'carlistingdealers';
    protected $guarded = [];
}