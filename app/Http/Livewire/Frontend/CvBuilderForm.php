<?php

namespace App\Http\Livewire\Frontend;

use App\Models\User;
use Livewire\Component;
use App\Models\ContentLive;
use App\Models\CvReference;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CvBuilderForm extends Component
{

    public $activeTab;
    public $first_name;
    public $last_name;
    public $address;
    public $email;
    public $phone;
    public $personal_profile;
    public $additional_interests;
    public $relatedReferences = [];

    protected $listeners = ['update_references_order' => 'updateReferencesOrder',
                            ];

    public function mount()
    {

        $cv = Auth::guard('web')->user()->cv()->select('id', 'first_name', 'last_name', 'address', 'email', 'phone', 'personal_profile', 'additional_interests')->first();

        if (!$cv)
        {
            $cv = Auth::guard('web')->user()->cv()->create(['first_name' => Auth::guard('web')->user()->first_name, 'last_name' => Auth::guard('web')->user()->last_name]);
        }

        //dd($cv);
        $this->first_name = $cv->first_name;
        $this->last_name = $cv->last_name;
        $this->address = $cv->address;
        $this->email = $cv->email;
        $this->phone = $cv->phone;
        $this->personal_profile = $cv->personal_profile;
        $this->additional_interests = $cv->additional_interests;

        $this->relatedReferences = $cv->references->toArray();
//dd($this->relatedReferences);
        /* $references = $cv->references()->get();
        foreach($references as $reference)
        {



        } */

        $this->activeTab = "personal-details";
    }


    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }



    /**
     * Add a reference
     */
    public function addRelatedReference()
    {
        $this->relatedReferences[] = ['id' => 0,
                                      'name' => '',
                                      'job_role' => '',
                                      'company' => '',
                                      'address_1' => '',
                                      'address_2' => '',
                                      'address_3' => '',
                                      'postcode' => '',
                                      'phone' => '',
                                      'email' => '',
                                    ];


    }

    /**
     * Remove a reference
     */
    public function removeRelatedReference($relatedReferencesIteration)
    {
        unset($this->relatedReferences[$relatedReferencesIteration]);
    }

    /**
     * updateReferencesOrder
     *
     * @param  mixed $referencesOrder
     * @return void
     */
    public function updateReferencesOrder($referencesOrder)
    {

        $referencesOrder = explode(",", $referencesOrder);

        $tmpReferences = [];

        foreach($referencesOrder as $key => $value)
        {
            $tmpReferences[] = $this->relatedReferences[$value];
        }

        $this->relatedReferences = $tmpReferences;

    }







    public function store()
    {

        $cv = Auth::guard('web')->user()->cv()->first();

        $cvData = ['first_name' => $this->first_name,
                   'last_name' => $this->last_name,
                   'address' => $this->address,
                   'email' => $this->email,
                   'phone' => $this->phone,
                   'personal_profile' => $this->personal_profile,
                   'additional_interests' => $this->additional_interests,
                ];

        $cv->update($cvData);


        //delete all videos attached to the live content
        $cv->references()->delete();



/*          //stores in an the data to be saved as it will contain the cv_id property
            $refs = [];
            //$refIds = [];

            //gets references of the current references from the DB
            $dbRefIdsToDelete = $cv->references->pluck('id')->toArray();

            //for each livewire reference
            foreach($this->relatedReferences as $key => $relatedReference)
            {

                //ads aproperty to the $relatedReference
                $relatedReference['cv_id'] = $cv->id;

                $refs[] = $relatedReference;

                //checks if the livewire reference is has been removed via livewire
                //search for the array position of the livewire reference in the $dbRefIdsToDelete array
                //if found, remve from the array, and it will not be deleted
                $position = array_search($relatedReference['id'], $dbRefIdsToDelete);
                if (is_numeric($position))
                {
                    unset($dbRefIdsToDelete[$position]);
                }

            }


            //if any reference needs to be saved
            if ($refs)
            {
                //do an upsert, which creates and update the records
                $cv->references()->upsert($refs,
                                            'id',
                                            ['name', 'job_role', 'company', 'address_1', 'address_2', 'address_3', 'postcode', 'email', 'phone',]);

                //if some existing records need to be removed
                if (count($dbRefIdsToDelete) > 0)
                {
                    DB::table('cv_references')->where('cv_id', '=', $cv->id)->whereIn('id', $dbRefIdsToDelete)->delete();
                }

            } else {

                DB::table('cv_references')->where('cv_id', '=', $cv->id)->whereIn('id', $dbRefIdsToDelete)->delete();

            }


            //reload the references
            $this->relatedReferences = $cv->references->toArray();
 */


        //create the videos to attach to content
        foreach($this->relatedReferences as $key => $relatedReference){

            $model = new CvReference();
            $model->name = $relatedReference['name'];
            $model->job_role = $relatedReference['job_role'];
            $model->company = $relatedReference['company'];
            $model->address_1 = $relatedReference['address_1'];
            $model->address_2 = $relatedReference['address_2'];
            $model->address_3 = $relatedReference['address_3'];
            $model->postcode = $relatedReference['postcode'];
            $model->email = $relatedReference['email'];
            $model->phone = $relatedReference['phone'];

            $cv->references()->save($model);
        }



    }


    public function exportAsPdf()
    {

        $this->store();

        //$cv = Auth::guard('web')->user()->cv()->select('id', 'first_name', 'last_name', 'address', 'email', 'phone', 'personal_profile', 'additional_interests', 'cvs.id')->first();

        dd( User::with('cv', 'cv.references')->find('64') );
        dd( User::where('id', 64)->take(1)->with('cv', 'cv.references')->get() );
//dd( Auth::guard('web')->user()->cv()->with('references')->get() );

        $pdf = PDF::setOptions(['show_warnings' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => false, 'chroot' => [ realpath(base_path()).'/public/images', realpath(base_path()).'/public/media'] ])
        ->loadView('frontend.pages.cv-builder.pdf.template1', compact('cv'))->output();

        return response()->streamDownload(
            fn() => print($pdf),
            'MyCV-'.date('YmdHis').'.pdf'
        );

    }


    public function render()
    {
        return view('livewire.frontend.cv-builder-form');
    }

}
