<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ForUserIndustrialCityScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {


        //   dd( auth()->user()->industrials);

        if (auth()->check() &&  !auth()->user()->hasRole('SuperAdmin')) {

            $industrialId = auth()->user()->industrials()->first();
            $builder->where('industrial_city_id', $industrialId->id);
        }
    }
}
