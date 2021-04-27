<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\ContentTemplate;



class ManageContentFilter extends Component
{

    public $types = [];

    //setup of the component
    public function mount()
    {

        $this->types = ContentTemplate::where('show', 'Y')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

    }

    //renders the component
    public function render()
    {

        return view('livewire.admin.manage-content-filter');

    }
}
