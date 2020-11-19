<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemTag;

class SelfAssessmentSubjects extends Component
{

    public $subjects;
    public $selectedSubjects;

    protected $rules = [
        'selectedSubjects' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        // Execution doesn't reach here if validation fails.

        dd('123');


    }



    public function AddSelectedSubjects($subjectId)
    {

        array_push($this->selectedSubjects, $subjectId);

dd($this->selectedSubjects);
    }

    //setup of the component
    public function mount()
    {
        $this->subjects = SystemTag::where('type', 'subject')->where('live', 'Y')->get();
        $this->selectedSubjects = [];
    }

    public function render()
    {
        return view('livewire.frontend.self-assessment-subjects', ['subjects' => $this->subjects]);
    }
}
