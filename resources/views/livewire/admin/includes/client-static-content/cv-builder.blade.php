<div id="cv-builder" class="tab-pane @if ($activeTab == "cv-builder") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>Introduction Screen</h2>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_introduction', 'Main Introduction Text'); !!}
                {!! Form::textarea('cv_introduction', $cv_introduction, array('placeholder' => 'Main Introduction Text', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_introduction')) !!}
            </div>

             <div class="form-group" wire:ignore>
                {!! Form::label('cv_useful_articles', 'Useful Articles'); !!}
                {!! Form::textarea('cv_useful_articles', $cv_useful_articles, array('placeholder' => 'Useful Articles', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_useful_articles')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_instructions', 'Instructions'); !!}
                {!! Form::textarea('cv_instructions', $cv_instructions, array('placeholder' => 'Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_instructions')) !!}
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>Personal Details Tab</h2>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_personal_details_instructions', 'Personal Details Instructions'); !!}
                {!! Form::textarea('cv_personal_details_instructions', $cv_personal_details_instructions, array('placeholder' => 'Personal Details Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_personal_details_instructions')) !!}
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>Personal Profile Tab</h2>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_personal_profile_instructions', 'Personal Profile Instructions'); !!}
                {!! Form::textarea('cv_personal_profile_instructions', $cv_personal_profile_instructions, array('placeholder' => 'Personal Profile Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_personal_profile_instructions')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_personal_profile_example', 'Personal Profile Example'); !!}
                {!! Form::textarea('cv_personal_profile_example', $cv_personal_profile_example, array('placeholder' => 'Personal Profile Example', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_personal_profile_example')) !!}
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>Key Skills Tab</h2>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_key_skills_instructions', 'Key Skills Instructions'); !!}
                {!! Form::textarea('cv_key_skills_instructions', $cv_key_skills_instructions, array('placeholder' => 'Key Skills Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_key_skills_instructions')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_key_skills_example', 'Key Skills Example'); !!}
                {!! Form::textarea('cv_key_skills_example', $cv_key_skills_example, array('placeholder' => 'Key Skills Example', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_key_skills_example')) !!}
            </div>


            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>Experience Tab</h2>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_experience_instructions', 'Experience Instructions'); !!}
                {!! Form::textarea('cv_experience_instructions', $cv_experience_instructions, array('placeholder' => 'Experience Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_experience_instructions')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_tasks_example', 'Duties / Tasks / Responsibilities Example'); !!}
                {!! Form::textarea('cv_tasks_example', $cv_tasks_example, array('placeholder' => 'Duties / Tasks / Responsibilities Example', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_tasks_example')) !!}
            </div>


            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>Education Tab</h2>

            <div class="form-group"wire:ignore
                {!! Form::label('cv_education_instructions', 'Education Instructions'); !!}
                {!! Form::textarea('cv_education_instructions', $cv_education_instructions, array('placeholder' => 'Education Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_education_instructions')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_education_example', 'Education Example'); !!}
                {!! Form::textarea('cv_education_example', $cv_education_example, array('placeholder' => 'Education Example', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_education_example')) !!}
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>Additional Interests Tab</h2>

            <div class="form-group"wire:ignore
                {!! Form::label('cv_additional_interests_instructions', 'Additional Interests Instructions'); !!}
                {!! Form::textarea('cv_additional_interests_instructions', $cv_additional_interests_instructions, array('placeholder' => 'Additional Interests Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_additional_interests_instructions')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_additional_interests_example', 'Additional Interests Example'); !!}
                {!! Form::textarea('cv_additional_interests_example', $cv_additional_interests_example, array('placeholder' => 'Additional Interests Example', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_additional_interests_example')) !!}
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>References Tab</h2>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_references_instructions', 'References Instructions'); !!}
                {!! Form::textarea('cv_references_instructions', $cv_references_instructions, array('placeholder' => 'References Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_references_instructions')) !!}
            </div>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_references_example', 'References Example'); !!}
                {!! Form::textarea('cv_references_example', $cv_references_example, array('placeholder' => 'References Example', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_references_example')) !!}
            </div>

            <div class="form-split"></div>

            <h2 class="border-bottom pb-2 mb-4"><i class="far fa-edit mr-2"></i>References Tab</h2>

            <div class="form-group" wire:ignore>
                {!! Form::label('cv_layout_instructions', 'Layout Instructions'); !!}
                {!! Form::textarea('cv_layout_instructions', $cv_layout_instructions, array('placeholder' => 'Layout Instructions', 'cols' => "40", 'rows' => "5", 'class' => 'form-control tiny_body', 'wire:model.defer' => 'cv_layout_instructions')) !!}
            </div>

        </div>
    </div>
</div>
