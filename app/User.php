<?php

namespace App;
use App\Models\UserActivity;
use App\Models\AuthenticationLog;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'email',
        'first_name',
        'last_name',
        'address',
        'city',
        'house_number',
        'postal_code',
        'telephone_number',
        'status',
        'password',
        
    ];
    public $sortable = ['user_name', 'email', 'first_name'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function userHistory()
    {
        return $this->MorphMany(UserActivity::class, 'entity')->with('modifiedBy')
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Relation to get last login information of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userLastLoginDetails()
    {
        return $this->hasMany(AuthenticationLog::class)->orderBy('created_at', 'desc')->limit(1);
    }
    public function sorting()
{
    return $this->hasMany('App\User');
}
}
