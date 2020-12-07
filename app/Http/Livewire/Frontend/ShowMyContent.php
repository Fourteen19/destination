<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\ContentLive;

class ShowMyContent extends Component
{

    public $content = [];

    //setup of the component
    public function mount()
    {

    }

    public function render()
    {

        $content = ContentLive::select('uuid', 'slug', 'title')->withAnyTags([7], 'year')->withAnyTags(['2-3'], 'lscs')->get();

        return view('livewire.frontend.show-my-content', ['contents' => $content]);
    }
}
