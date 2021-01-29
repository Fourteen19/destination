<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\StaticClientContent;
use Illuminate\Support\Facades\Session;

class ClientStaticContent extends Component
{

    public StaticClientContent $staticClientContent;

    public $activeTab;

    protected $rules = [
        'staticClientContent.tel' => 'nullable',
        'staticClientContent.email' => 'nullable|email',

        'staticClientContent.terms' => 'nullable',
        'staticClientContent.privacy' => 'nullable',
        'staticClientContent.cookies' => 'nullable',

        'staticClientContent.pre_footer_heading' => 'nullable',
        'staticClientContent.pre_footer_body' => 'nullable',
        'staticClientContent.pre_footer_button_text' => 'nullable',
        'staticClientContent.pre_footer_link' => 'nullable',

        'staticClientContent.login_intro' => 'nullable',
        'staticClientContent.welcome_intro' => 'nullable',
        'staticClientContent.careers_intro' => 'nullable',
        'staticClientContent.subjects_intro' => 'nullable',
        'staticClientContent.routes_intro' => 'nullable',
        'staticClientContent.sectors_intro' => 'nullable',
        'staticClientContent.assessment_completed_txt' => 'nullable',

        'staticClientContent.support_block_heading' => 'nullable',
        'staticClientContent.support_block_body' => 'nullable',
        'staticClientContent.support_block_button_text' => 'nullable',
        'staticClientContent.support_block_link' => 'nullable',
        'staticClientContent.get_in_right_heading' => 'nullable',
        'staticClientContent.get_in_right_body' => 'nullable',
    ];

    protected $messages = [

    ];


    public function mount()
    {

        $this->staticClientContent = StaticClientContent::select(
                    'tel', 'email',  //contact details

                    'terms', 'privacy', 'cookies', //legal

                    'pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link', //public content

                    'login_intro', 'welcome_intro',
                    'careers_intro', 'subjects_intro', 'routes_intro', 'sectors_intro', 'assessment_completed_txt', //self assessment

                    'support_block_heading', 'support_block_body', 'support_block_button_text', 'support_block_link',
                    'get_in_right_heading', 'get_in_right_body',)  //logged in content
                                    ->where('client_id', session()->get('adminClientSelectorSelected') )
                                    ->first();


        $this->activeTab = "contact-details";

    }


    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }


    public function updatedEmail()
    {
        $this->validateOnly('email',
                        ['email' => 'nullable|email']
        );
    }

    public function storeAndMakeLive()
    {

        $this->validate($this->rules, $this->messages);

        DB::beginTransaction();

        try {

            //$this->staticClientContent->where('client_id', '=', session()->get('adminClientSelectorSelected') )->update();

            DB::commit();

            Session::flash('success', 'Your content has been updated Successfully');
        }
        catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Your content could not be been updated');

        }

    }


    public function render()
    {

        return view('livewire.admin.client-static-content');

    }

}
