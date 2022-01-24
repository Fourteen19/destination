<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class VacancyGlobalAndClientScope implements Scope
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

        //if the page is in the frontend OR
        //if the page if the page is requested from a
        if ( (Route::is('frontend.*')) || ( (Route::is('frontend.*')) && Route::is("livewire.message") ) )
        {

            //if the user is logged in the frontend
            if (Auth::guard('web')->check()){

                //if the logged in user is of type `user`
                if (Auth::guard('web')->user()->type == 'user')
                {
                    $clientId = Auth::guard('web')->user()->institution->client_id;
                } elseif (Auth::guard('web')->user()->type == 'admin') {
                    $clientId = Session::get('fe_client')['id'];
                }

            } else {
                $clientId = Session::get('fe_client')['id'];
            }

            $builder->where(function($query) use ($clientId) {
                $query->where('all_clients', 'Y')
                    ->orwhereHas('clients', function($query) use ($clientId) {
                        $query->where('client_id', $clientId);
                    });
            });

        //if logged in the backend
        } elseif (Auth::guard('admin')->check()){

            //if the user is logged in the backend
            if (Auth::guard('admin')->check()){
                $clientId = Session::get('adminClientSelectorSelected');
            }

        }

    }

}
