<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthenticationLog extends Model
{
    protected $fillable = [
        'user_id',
        'login_time',
        'logout_time',
        'browser_agent',
        'ip_address',
    ];
}
