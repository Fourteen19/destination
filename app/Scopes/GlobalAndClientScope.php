<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class GlobalAndClientScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        //if the user is logged in
        //we need to run a check here so we do not use this when the seeder is run
        if (Auth::guard('web')->check()){
            $builder->where('client_id', '=', Auth::guard('web')->user()->institution->client_id);
            $builder->orwhere('client_id', '=', NULL);
        }

    }
}
