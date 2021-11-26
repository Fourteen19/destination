<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Cv;
//use Dompdf\FontMetrics;
use Livewire\Component;
use App\Models\CvEducation;
use App\Models\CvReference;
use App\Models\CvEmployment;
use App\Models\CvEducationGrade;
use App\Models\CvEmploymentTask;
use App\Models\CvEmploymentSkill;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    public $relatedEducations = [];
    public $relatedEmployments = [];
    public $relatedEmploymentSkills = [];
    public $template = "";
    public $staticContent = [];
    public $addPageBreakBeforeEmployment;
    public $addPageBreakBeforeEducation;
    public $addPageBreakBeforeAdditionalInterest;
    public $addPageBreakBeforeReferences;



    protected $listeners = ['update_references_order' => 'updateReferencesOrder',
                            'update_educations_order' => 'updateEducationsOrder',
                            'update_educations_grades_order' => 'updateEducationsGradesOrder',
                            'update_employments_order' => 'updateEmploymentsOrder',
                            'update_employments_tasks_order' => 'updateEmploymentsTasksOrder',
                            'update_employment_skills_order' => 'updateEmploymentSkillsOrder',
                            ];



    public function mount()
    {


        //text around the livewire element
        $this->staticContent = app('clientContentSettigsSingleton')->getCvBuilderText();

        $cv = Auth::guard('web')->user()->cv()->select('id')->first();

        //if no cv exists for the user
        if ($cv)
        {
            $cv = Cv::with('references', 'educations', 'educations.grades', 'employments', 'employments.tasks', 'employmentSkills')->where('id', $cv->id)->first();
        } else {
            $cv = Auth::guard('web')->user()->cv()->create(['first_name' => Auth::guard('web')->user()->first_name, 'last_name' => Auth::guard('web')->user()->last_name]);
        }


        $this->first_name = $cv->first_name;
        $this->last_name = $cv->last_name;
        $this->address = $cv->address;
        $this->email = $cv->email;
        $this->phone = $cv->phone;
        $this->personal_profile = $cv->personal_profile;
        $this->additional_interests = $cv->additional_interests;
        $this->addPageBreakBeforeEmployment = ($cv->page_break_before_employment == "Y") ? True : False;
        $this->addPageBreakBeforeEducation = ($cv->page_break_before_education == "Y") ? True : False;
        $this->addPageBreakBeforeAdditionalInterest = ($cv->page_break_before_additional_interests == "Y") ? True : False;
        $this->addPageBreakBeforeReferences = ($cv->page_break_before_references == "Y") ? True : False;

        $this->relatedReferences = $cv->references->toArray();
        $this->relatedEducations = $cv->educations->toArray();
        $this->relatedEmployments = $cv->employments->toArray();
        $this->relatedEmploymentSkills = $cv->employmentSkills->toArray();

        $this->template = 1;

        $this->template = $this->defineTemplate();

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







    /****************************/

    /**
     * Add an emplyment line
     */
    public function addRelatedEmployment()
    {
        $this->relatedEmployments[] = ['organisation' => '',
                                      'job_role' => '',
                                      'job_type' => 'employed',
                                      'from' => '',
                                      'to' => '',
                                      'tasks_type' => 'bullets',
                                      'tasks_txt' => '',
                                      'tasks' => [],
                                    ];



    }


    /**
     * Remove a education
     */
    public function removeRelatedEmployment($relatedEmploymentsIteration)
    {
        unset($this->relatedEmployments[$relatedEmploymentsIteration]);
    }


    /**
     * updateEmploymentsOrder
     *
     * @param  mixed $empoymentsOrder
     * @return void
     */
    public function updateEmploymentsOrder($empoymentsOrder)
    {

        $empoymentsOrder = explode(",", $empoymentsOrder);

        $tmpEmployments = [];

        foreach($empoymentsOrder as $key => $value)
        {
            $tmpEmployments[] = $this->relatedEmployments[$value];
        }

        $this->relatedEmployments = $tmpEmployments;

    }


    /****************************/


    /**
     * Add an employment task line
     */
    public function addRelatedEmploymentTask($employmentId)
    {
        $this->relatedEmployments[$employmentId]['tasks'][] = [
                                            'description' => '',
                                            ];

    }


    /**
     * Remove a employment
     */
    public function removeRelatedEmploymentTasks($employmentId, $relatedEmploymentsTasksIteration)
    {
        unset($this->relatedEmployments[$employmentId]['tasks'][$relatedEmploymentsTasksIteration]);
    }


    /**
     * updateEmploymentsTasksOrder
     *
     * @param  mixed $employmentsOrder
     * @return void
     */
    public function updateEmploymentsTasksOrder($employmentsOrder)
    {
        // the data received look slike this if from first employment: 0-0,0-1,0-3,0-2
        $employmentsOrder = explode(",", $employmentsOrder);

        $tmpEmploymentsTasks = [];

        foreach($employmentsOrder as $key => $value)
        {
            //we explode 0-0, ...
            $employmentsOrderTasksData = explode("-", $value);

            $tmpEmploymentsTasks[] = $this->relatedEmployments[$employmentsOrderTasksData[0]]['tasks'][$employmentsOrderTasksData[1]];
        }

        $this->relatedEmployments[$employmentsOrderTasksData[0]]['tasks'] = $tmpEmploymentsTasks;

    }



    /****************************/




    /**
     * Add an employment skill
     */
    public function addRelatedEmploymentSkill()
    {
        $this->relatedEmploymentSkills[] = ['title' => '',
                                      'description' => ''
                                    ];

    }

    /**
     * Remove a employmentskill
     */
    public function removeRelatedEmploymentSkill($relatedEmploymentSkillsIteration)
    {
        unset($this->relatedEmploymentSkills[$relatedEmploymentSkillsIteration]);
    }

    /**
     * updateEmploymentSkillsOrder
     *
     * @param  mixed $employmentskillsOrder
     * @return void
     */
    public function updateEmploymentSkillsOrder($employmentskillsOrder)
    {

        $employmentskillsOrder = explode(",", $employmentskillsOrder);

        $tmpEmploymentSkills = [];

        foreach($employmentskillsOrder as $key => $value)
        {
            $tmpEmploymentSkills[] = $this->relatedEmploymentSkills[$value];
        }

        $this->relatedEmploymentSkills = $tmpEmploymentSkills;

    }


    /****************************/







    /**
     * Add an education line
     */
    public function addRelatedEducation()
    {
        $this->relatedEducations[] = ['name' => '',
                                      'from' => '',
                                      'to' => '',
                                      'grades' => []
                                    ];

    }


    /**
     * Remove a education
     */
    public function removeRelatedEducation($relatedEducationsIteration)
    {
        unset($this->relatedEducations[$relatedEducationsIteration]);
    }


    /**
     * updateEducationsOrder
     *
     * @param  mixed $educationsOrder
     * @return void
     */
    public function updateEducationsOrder($educationsOrder)
    {

        $educationsOrder = explode(",", $educationsOrder);

        $tmpEducations = [];

        foreach($educationsOrder as $key => $value)
        {
            $tmpEducations[] = $this->relatedEducations[$value];
        }

        $this->relatedEducations = $tmpEducations;

    }



    /****************************/


    /**
     * Add an education grades line
     */
    public function addRelatedEducationGrade($educationId)
    {
        $this->relatedEducations[$educationId]['grades'][] = [
                                            'title' => '',
                                            'grade' => '',
                                            'predicted' => 'N',
                                            ];

    }


    /**
     * Remove a education
     */
    public function removeRelatedEducationGrades($educationId, $relatedEducationsGradesIteration)
    {
        unset($this->relatedEducations[$educationId]['grades'][$relatedEducationsGradesIteration]);
    }


    /**
     * updateEducationsGradesOrder
     *
     * @param  mixed $educationsOrder
     * @return void
     */
    public function updateEducationsGradesOrder($educationsOrder)
    {
        // the data received look slike this if from first education: 0-0,0-1,0-3,0-2
        $educationsOrder = explode(",", $educationsOrder);

        $tmpEducationsGrades = [];

        foreach($educationsOrder as $key => $value)
        {
            //we explode 0-0, ...
            $educationsOrderGradesData = explode("-", $value);

            $tmpEducationsGrades[] = $this->relatedEducations[$educationsOrderGradesData[0]]['grades'][$educationsOrderGradesData[1]];
        }
//dd($tmpEducationsGrades);
        $this->relatedEducations[$educationsOrderGradesData[0]]['grades'] = $tmpEducationsGrades;

    }



    /****************************/





    /**
     * Add a reference
     */
    public function addRelatedReference()
    {
        $this->relatedReferences[] = ['name' => '',
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


    /****************************/


    public function updated($propertyName)
    {

        if (strpos($propertyName, '.job_type') !== false) {

            $this->template = $this->defineTemplate();

        }


    }





    public function store()
    {

        DB::beginTransaction();

        try {


            $cv = Auth::guard('web')->user()->cv()->first();

            $cvData = ['first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'address' => $this->address,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'personal_profile' => $this->personal_profile,
                    'additional_interests' => $this->additional_interests,
                    'page_break_before_employment' => ($this->addPageBreakBeforeEmployment) ? 'Y' : 'N',
                    'page_break_before_education' => ($this->addPageBreakBeforeEducation) ? 'Y' : 'N',
                    'page_break_before_additional_interests' => ($this->addPageBreakBeforeAdditionalInterest) ? 'Y' : 'N',
                    'page_break_before_references' => ($this->addPageBreakBeforeReferences) ? 'Y' : 'N',
                    ];

            $cv->update($cvData);


            //dd(Auth::guard('web')->user());
            Auth::guard('web')->user()->update(['cv_builder_completed' => "Y"]);


            //delete all videos attached to the cv
            $cv->references()->delete();

            //create the references to attach to cv
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

            /*********************************/

            //delete all videos attached to the cv
            $cv->educations()->delete();

            //create the related education to attach to content
            foreach($this->relatedEducations as $key => $relatedEducation)
            {

                $educationModel = new CvEducation();
                $educationModel->name = $relatedEducation['name'];
                $educationModel->from = $relatedEducation['from'];
                $educationModel->to = $relatedEducation['to'];

                $educationModel = $cv->educations()->save($educationModel);

                foreach($relatedEducation['grades'] as $keyGrade => $grade)
                {
                    $gradeModel = new CvEducationGrade();
                    $gradeModel->title = $grade['title'];
                    $gradeModel->grade = $grade['grade'];
                    $gradeModel->predicted = $grade['predicted'];

                    $educationModel->grades()->save($gradeModel);
                }

            }

            /*********************************/

            //delete all videos attached to the cv
            $cv->employments()->delete();

            //create the related employments to attach to cv
            foreach($this->relatedEmployments as $key => $relatedEmployment)
            {

                $employmentModel = new CvEmployment();
                $employmentModel->organisation = $relatedEmployment['organisation'];
                $employmentModel->job_role = $relatedEmployment['job_role'];
                $employmentModel->job_type = $relatedEmployment['job_type'];
                $employmentModel->from = $relatedEmployment['from'];
                $employmentModel->to = $relatedEmployment['to'];
                $employmentModel->tasks_type = $relatedEmployment['tasks_type'];
                $employmentModel->tasks_txt = $relatedEmployment['tasks_txt'];

                $educationModel = $cv->employments()->save($employmentModel);

                if (count($relatedEmployment['tasks']) > 0)
                {

                    foreach($relatedEmployment['tasks'] as $keyTask => $task)
                    {
                        $taskModel = new CvEmploymentTask();
                        $taskModel->description = $task['description'];

                        $employmentModel->tasks()->save($taskModel);
                    }

                }

            }

            /**********************/


            //delete all employment skills attached to the cv
            $cv->employmentSkills()->delete();

            //create the related references to attach to cv
            foreach($this->relatedEmploymentSkills as $key => $relatedEmploymentSkill){

                $model = new CvEmploymentSkill();
                $model->title = $relatedEmploymentSkill['title'];
                $model->description = $relatedEmploymentSkill['description'];

                $cv->employmentSkills()->save($model);
            }

            /*********************************/

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error', 'There was an error saving your CV');

        }

    }



    /**
     * defineTemplate
     * define which temaplte to use depending on the data entered
     *
     * @return void
     */
    public function defineTemplate()
    {

        $template = 1;

        $nbWorkExperience = 0;
        //loops through the employment history
        foreach($this->relatedEmployments as $key => $relatedEmployment)
        {
            //checks if the employment is "work-experience"
            if ($relatedEmployment['job_type'] == "work-experience")
            {
                $nbWorkExperience = $nbWorkExperience + 1;
            }
        }

        //if all the jobs were "work experience"
        if ($nbWorkExperience == count($this->relatedEmployments))
        {
            $template = 2;
        }

        return $template;

    }





    public function exportAsPdf()
    {

        $this->store();

        $cv = Auth::guard('web')->user()->cv()->select('id')->first();

        $cv = Cv::with('references', 'educations', 'educations.grades', 'employments', 'employments.tasks')->where('id', $cv->id)->first();

        $this->template = $this->defineTemplate();

        $pdf = PDF::setOptions(['show_warnings' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => false, 'chroot' => [ realpath(base_path()).'/public/images', realpath(base_path()).'/public/media'] ])
        ->loadView('frontend.pages.cv-builder.pdf.template'.$this->template, compact('cv'))->output();


        /*

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();

        $options = $dom_pdf->getOptions();
        $options->setDefaultFont('helvetica');
        $dom_pdf->setOptions($options);

        //$options = $dom_pdf->getOptions();
//dd($options);

       // dd($dom_pdf->getFontMetrics());

        $fontMetrics = $dom_pdf->getFontMetrics();
        //$font = $fontMetrics->getFont('serif');
        $font = $fontMetrics->getFont('helvetica', "normal");

//    #_width: 595.28
//    #_height: 841.89

        $text = "I am a highly competent IT professional with a proven track record in designing websites, networking and managing databases. I have strong technical skills as well as excellent interpersonal skills, enabling me to interact with a wide range of clients. I am eager";

        $width = $fontMetrics->getTextWidth($text, $font, 12);

        dd($width / (595.28));  //height_ratio *1.1 ???

 */

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