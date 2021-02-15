<?php

namespace App\Scopes\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class BelongsToClientScope implements Scope
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
        if (Auth::guard('admin')->check()){
            $builder->where('client_id', '=', getClientId() ); //Auth::guard('admin')->user()->client_id
        }

    }
}
