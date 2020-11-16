<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Content;

class ShowMyContent extends Component
{

    public $content = [];

    //setup of the component
    public function mount()
    {

    }

    public function render()
    {

        $content = Content::select('uuid', 'title')->get();

        return view('livewire.frontend.show-my-content', ['contents' => $content]);
    }
}
