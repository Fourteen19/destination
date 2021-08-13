<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Institution;

class DatatableUserTransfer extends Component
{

    protected $listeners = ['userAdded' => 'userAdded'];

    public $institutions = [];
    public $institution;
    public $displayTransferButton = 'N';

    //setup of the component
    public function mount($institution, $displayTransferButton)
    {
        $this->institution = $institution;
        $this->displayTransferButton = $displayTransferButton;
    }


    public function transfer()
    {


    }



    public function userAdded($users)
    {

        if (count($users) > 0)
        {
            $this->displayTransferButton = 'Y';
        } else {
            $this->displayTransferButton = 'N';
        }


    }

    //renders the component
    public function render()
    {

        //finds the institutions filtering by client
        $this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

        return view('livewire.admin.datatable-user-transfer');

    }
}
