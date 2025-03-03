<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Role;
use App\Models\IndustrialCity;
use App\Models\Scopes\ForUserIndustrialCityScope;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Traits\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


#[ScopedBy([ForUserIndustrialCityScope::class])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        
        'status',
        'activation',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected static function booted()
    // {
    //     static::addGlobalScope(new ForUserIndustrialCityScope);
    // }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute()
    {
        return  $this->first_name . ' '. $this->last_name;
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function industrials()
    {
        return $this->belongsToMany(IndustrialCity::class,'industrial_user','user_id','industrial_id');
    }

    
}
