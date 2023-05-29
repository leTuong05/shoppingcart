<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use SoftDeletes;
    
    protected $fillable =[
        'name',
        'email',
        'email_verified_at',
        'avatar',
        'role',
        'remember_token',
    ];

    protected $hidden = ['password'];
}
