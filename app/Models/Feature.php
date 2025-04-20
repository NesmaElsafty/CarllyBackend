<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'features';

    public function packages()
{
    return $this->belongsToMany(Package::class);
}

 }
