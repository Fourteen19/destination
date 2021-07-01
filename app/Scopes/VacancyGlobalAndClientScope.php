<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Auth;
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
        //if the user is logged in the frontend
        if (Auth::guard('web')->check()){

            //if the logged in user is of type `user`
            if (Auth::guard('web')->user()->type == 'user')
            {
                $clientid = Auth::guard('web')->user()->institution->client_id;
            } elseif (Auth::guard('web')->user()->type == 'admin') {
                $clientid = Session::get('fe_client')['id'];
            }

        //if not logged in the frontend
        } else {

            //if the user is logged in the backend
            if (Auth::guard('admin')->check()){
                $clientid = Session::get('client')['id'];
            } else {
                $clientid = Session::get('fe_client')['id'];
            }


        }


        $builder->leftJoin('clients_vacancies_live', 'vacancies_live.id', '=', 'clients_vacancies_live.vacancy_live_id');
        $builder->where('vacancies_live.all_clients', '=', 'Y');
        $builder->orWhere(function($query) use ($clientid){
            $query->where('all_clients', 'N');
            $query->where('clients_vacancies_live.client_id', $clientid);
        });



    }
}
