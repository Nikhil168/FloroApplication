<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class PasswordSecurity extends Model
{
    use HasApiTokens;
}
