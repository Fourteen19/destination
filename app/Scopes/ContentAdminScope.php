<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ContentAdminScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function contentAdmin(Builder $builder, Model $model)
    {
/*
        if (in_array(Auth::guard('admin')->getRoleNames()->first(), [config("global.admin_user_type.System_Administrator"), config("global.admin_user_type.Global_Content_Admin")]))
        {
            $builder->where('client_id', '=', NULL);

        } elseif (in_array(Auth::guard('admin')->getRoleNames()->first(), [config("global.admin_user_type.Client_Admin"), config("global.admin_user_type.Client_Content_Admin")]))

            $builder->where('client_id', '=', Auth::guard('admin')->client_id);

        }
        */
    }
}
