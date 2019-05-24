<?php
namespace App\Repositories;

use App\Models\PasswordSecurity;

class PasswordSecurityRepository extends Repository
{
    public function __construct(PasswordSecurity $model)
        {
            $this->model=$model;
        }
    
}