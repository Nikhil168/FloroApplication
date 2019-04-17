<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class UserActivity extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'id','entity_type','entity_id','field_name', 'old_value', 'new_value', 'modified_by',
    ];

    public function entity()
    {
        return $this->morphTo();
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
