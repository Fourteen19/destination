<?php

namespace App\Http\Livewire;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AdminDataTable extends TableComponent
{
    use HtmlComponents;

    
    public $clearSearchButton = true;
    public $sortField = "last_name";
    public $loadingIndicator = true;
    public $sortDirection = "DESC";
//    public $refresh = "refreshPage";

    public function query() : Builder
    {
        return Admin::query();
    }

    public function columns() : array
    {
        return [
            Column::make('Name', 'last_name')
                ->searchable()
                ->sortable()
                ->format(function(Admin $model) {
                    return $this->html($model->fullName);
                }),
            Column::make('Email')
                ->searchable()
                ->sortable(),
            Column::make('Action')->format(function(Admin $model) {
                return view('admin.pages.admins.includes.actions', ['user' => $model]);
            }),
        ];
    }

}
