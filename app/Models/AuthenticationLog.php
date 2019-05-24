<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class AuthenticationLog extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'user_id',
        'login_time',
        'logout_time',
        'browser_agent',
        'ip_address',
    ];
}
