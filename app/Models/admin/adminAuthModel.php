<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class adminAuthModel extends  Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = 'admin_settings';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'pass',
        'api_token',
    ];

    public function getImageAttribute() {
        return asset($this->image);
    }

}