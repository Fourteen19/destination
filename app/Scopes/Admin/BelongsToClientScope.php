<?php

namespace App\Scopes\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Session;
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
            //gets the client based on the dropdown selected or the client the user is associated with
            $builder->where('client_id', '=', getClientId() );
        } else {
            /*
            //if the frontend user is logged in, use the session var
            if (Session::has('fe_client'))
            {
                $builder->where('client_id', '=', Session::get('fe_client')->id );

            //else if not logged in ie. FOR SEEDER, use client 1
            } else {
                $builder->where('client_id', '=', 1);
            }*/
        }

    }
}
