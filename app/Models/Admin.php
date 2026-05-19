<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_admin',
        'pass_admin',
        'tel_admin',
        'ci_admin',
    ];

    protected $hidden = [
        'pass_admin',
    ];
}
