<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;
use App\Jobs\BatchDeleteUser;
use Illuminate\Support\Facades\Auth;

class DatatableUserDelete extends Component
{

    protected $listeners = ['userAdded' => 'userAdded',
                            'delete_users' => 'deleteUsers'];

    public $institutions = [];
    public $institutionFrom;
    public $displayDeleteButton = 'N';
    public $users = [];
    public $updateTxt = "";

    //setup of the component
    public function mount($displayDeleteButton)
    {
        $this->displayDeleteButton = $displayDeleteButton;

        //finds the institutions filtering by client
        //$this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

    }

/*
     public function delete()
    {

        if (count($this->users))
        {

            $institutionFrom = Institution::where('uuid', $this->institutionFrom)->select('id')->limit(1)->first();

            if ($institutionFrom)
            {

                //BatchDeleteUser::dispatch(Auth::guard('admin')->user()->email, $this->users, $institutionFrom->id);
                //->onQueue('transfer');
                //$this->updateTxt = "Your request is now being processed. You will receive an email when it is completed";


                //$this->emit("deleted");
                //$this->emit('reset_selectAll', True);


            } else {

                //$this->updateTxt = "The institution you want to transfer your users from can not be found";
                //$this->emit("deleted");
            }

        }

    }
*/


    public function userAdded($users, $institutionFrom)
    {

        if (count($users) > 0)
        {
            $this->displayDeleteButton = 'Y';
            $this->institutionFrom = $institutionFrom;
        } else {
            $this->displayDeleteButton = 'N';
        }

        $this->users = $users;
    }




    public function deleteUsers()
    {

        if (count($this->users))
        {

            $institutionFrom = Institution::where('uuid', $this->institutionFrom)->select('id')->limit(1)->first();

            if ($institutionFrom)
            {

                BatchDeleteUser::dispatch(Auth::guard('admin')->user()->email, $this->users, $institutionFrom->id);
                //->onQueue('transfer');
                $this->updateTxt = "Your request is now being processed. You will receive an email when it is completed";
                $this->emit("deleted");
            }

        }

    }



    //renders the component
    public function render()
    {

        return view('livewire.admin.datatable-user-delete');

    }
}
