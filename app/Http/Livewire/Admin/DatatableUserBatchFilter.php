<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Institution;

class DatatableUserBatchFilter extends Component
{

    protected $listeners = ['reset_batch_filter' => 'reset_batch_filter'];

    public $institutions = [];
    public $institution;
    public $year;
    public $displaySearchButton = 'N';
    public $action = "";

    //setup of the component
    public function mount($institution, $displaySearchButton, $action)
    {
        $this->institution = $institution;
        $this->displaySearchButton = $displaySearchButton;
        $this->action = ucfirst($action);
    }


    public function reset_batch_filter()
    {

        $this->institution = "";
        $this->year = "";
        $this->emit('reset_filter');
    }


    //renders the component
    public function render()
    {

        //finds the institutions filtering by client
        $this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

        return view('livewire.admin.datatable-user-batch-filter');

    }
}
