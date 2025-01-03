<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustrialCity extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'industrial_user','industrial_id','user_id');
    }
}
