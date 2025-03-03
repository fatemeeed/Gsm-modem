<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\ForUserIndustrialCityScope;


class IndustrialCity extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=['id'];


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'industrial_user','industrial_id','user_id');
    }

    public function sources()
    {
        return $this->hasMany(Source::class);
    }
    

}
