<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Institution;

class DatatableInstitutionFilter extends Component
{

    public $institutions = [];
    public $institution;

    //setup of the component
    public function mount($institution)
    {
        $this->institution = $institution;
    }

    //renders the component
    public function render()
    {

        //finds the institutions filtering by client
        $this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

        return view('livewire.admin.datatable-institution-filter');

    }
}