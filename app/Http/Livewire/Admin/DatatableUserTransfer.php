<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Institution;
use App\Jobs\BatchTransferUser;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedBatchTransfer;

class DatatableUserTransfer extends Component
{

    protected $listeners = ['userAdded' => 'userAdded',
                            'transfer_users' => 'transferUsers'];

    public $institutions = [];
    public $institutionFrom;
    public $institutionTo;
    public $displayTransferButton = 'N';
    public $users = [];
    public $updateTxt = "";

    //setup of the component
    public function mount($institution, $displayTransferButton)
    {
        $this->institution = $institution;
        $this->displayTransferButton = $displayTransferButton;

        //finds the institutions filtering by client
        $this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

    }


    public function transferUsers()
    {

        if (count($this->users))
        {

            $institutionFrom = Institution::where('uuid', $this->institutionFrom)->select('id', 'name')->limit(1)->first();
            $institutionTo = Institution::where('uuid', $this->institutionTo)->select('id', 'name')->limit(1)->first();

            if ($institutionTo)
            {

                BatchTransferUser::dispatch(Auth::guard('admin')->user()->email, $this->users, $institutionFrom->id, $institutionTo->id)->onQueue('batch_transfer')->chain([
                    new NotifyUserOfCompletedBatchTransfer(request()->user(), count($this->users), $institutionFrom->name, $institutionTo->name),
                ]);
                //->onQueue('transfer');
                $this->updateTxt = "Your request is now being processed. You will receive an email when it is completed";
                $this->emit("transfered");
                $this->emit('reset_selectAll', True);

            } else {

                $this->updateTxt = "The institution you want to transfer your users to can not be found";
                $this->emit("transfered");
            }

        }

    }



    public function userAdded($users, $institutionFrom)
    {

        if (count($users) > 0)
        {
            $this->displayTransferButton = 'Y';
            $this->institutionFrom = $institutionFrom;
        } else {
            $this->displayTransferButton = 'N';
        }

        $this->users = $users;
    }





    //renders the component
    public function render()
    {

        return view('livewire.admin.datatable-user-transfer');

    }
}
