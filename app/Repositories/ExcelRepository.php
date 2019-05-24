<?php
namespace App\Repositories;

use App\Models\Excel;

class ExcelRepository extends Repository
{
    public function __construct(Excel $model)
        {
            $this->model=$model;
        }
    
}