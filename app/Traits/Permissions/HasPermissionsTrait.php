<?php

namespace App\Traits\Permissions;

use App\Models\Role;


trait HasPermissionsTrait
{
    // ارتباط نقش‌ها
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

   

    // بررسی نقش‌ها
    public function hasRole(...$roles)
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

        return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
    }


    // اختصاص نقش‌ها
    public function assignRole(...$roles)
    {
        $roles = Role::whereIn('name', $roles)->get();

        if ($roles->isEmpty()) {
            return false;
        }

        $this->roles()->syncWithoutDetaching($roles);
        return true;
    }

    // حذف نقش‌ها
    public function removeRole(...$roles)
    {
        $roles = Role::whereIn('name', $roles)->get();

        if ($roles->isEmpty()) {
            return false;
        }

        $this->roles()->detach($roles);
        return true;
    }

   
}
