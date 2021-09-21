<div id="employment" class="tab-pane @if ($activeTab == "employment") active @else fade @endif">

    <div class="row">
        <div class="col-xl-12">

            <div class="px-lg-4">
                <div class="mb-3">{{ $staticContent['cv_experience_instructions'] }}</div>

                <div><b>Add Page break before this section in your PDF export?</b></div>
                <div class="">
                    {!! Form::checkbox('add_page_break_before_employment', "Y", $addPageBreakBeforeEmployment, ['id' => 'add_page_break_before_employment', 'wire:model.defer' => 'addPageBreakBeforeEmployment' ]) !!}
                    <label class="" for="add_page_break_before_employment">Yes</label>
                </div>

                <div><b>Do you have any employment history or work experience?</b></div>
                <div class="custom-control custom-radio">
                    <input wire:model="hasEmployment" name="hasEmployment" type="radio" value="Y" id="YESEmployment" class="custom-control-input" />
                    <label class="custom-control-label" for="YESEmployment">Yes</label>
                </div>
                <div class="custom-control custom-radio">
                    <input wire:model="hasEmployment" name="hasEmployment" type="radio" value="N" id="NOEmployment" class="custom-control-input"/>
                    <label class="custom-control-label" for="NOEmployment">No</label>
                </div>

                <div class="cv-split mb-5"></div>

            @if ($hasEmployment == 'Y')

            <h3 class="t20 fw600">Employment History / Previous Roles</h3>

                <div class="rounded p-4 cv-dyn-item">
                    <ul id="sortable-employments" class="drag-list">

                        @foreach($relatedEmployments as $key => $employment)
                        <li id="{{$key}}" class="drag-box" wire:key="employment-{{ $key }}">
                            <div class="row align-items-start">
                                <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <label>Employer / Organisation Name</label>
                                            <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Employer / Organisation Name" name="relatedEmployments[{{$key}}]['organisation']" wire:model.defer="relatedEmployments.{{$key}}.organisation">
                                            @error('relatedEmployments.'.$key.'.organisation')<span class="text-danger error">{{ $message }}</span>@enderror
                                            <div class="t14 mt-2">The name of the place where you worked.</div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            <label>Your Job / Role Title</label>
                                            <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Job / Role Title:" name="relatedEmployments[{{$key}}]['job_role']" wire:model.defer="relatedEmployments.{{$key}}.job_role">
                                            @error('relatedEmployments.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                            <div class="t14 mt-2">What was your official job title? i.e. Office Administrator, Shop Assistant etc.</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <label>Were you:</label>
                                            <select class="form-control form-control-lg" name="relatedEmployments[{{$key}}]['job_type']" wire:model.defer="relatedEmployments.{{$key}}.job_type">
                                                <option value="employed">Employed (Full or part time)</option>
                                                <option value="work-experience">Gaining work experience</option>
                                                <option value="volunteering">Volunteering</option>
                                            </select>
                                            @error('relatedEmployments.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>

                                        <div class="col-lg-3 mb-4">
                                            <label>The date you started</label>
                                            <input type="text" class="form-control form-control-lg lazy_element" maxlength="50" placeholder="From" name="relatedEmployments[{{$key}}]['from']" wire:model.defer="relatedEmployments.{{$key}}.from">
                                            @error('relatedEmployments.'.$key.'.from')<span class="text-danger error">{{ $message }}</span>@enderror
                                            <div class="t14 mt-2">When did you start working there e.g. April 2020.</div>
                                        </div>

                                        <div class="col-lg-3 mb-4">
                                            <label class="mr-2">The date you left</label>
                                            <input type="text" class="form-control form-control-lg lazy_element" maxlength="50" placeholder="To" name="relatedEmployments[{{$key}}]['to']" wire:model.defer="relatedEmployments.{{$key}}.to">
                                            @error('relatedEmployments.'.$key.'.to')<span class="text-danger error">{{ $message }}</span>@enderror
                                            <div class="t14 mt-2">If you still work there now, enter the word "Present".</div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12"><p><span class="t18 fw600">Describe what you did in your job.</span>
                                        <br>You can either list all your resposibilites and task as bullet points OR you can enter a short paragraph describing what you did in your role.</p></div>
                                    </div>

                                    <div class="row parent-bullet-para">
                                        <div class="col-12">
                                            <label class="mr-2">Select a style (bullets or paragraph)</label>
                                            <select class="form-control form-control-lg tasks_type" name="relatedEmployments[{{$key}}]['tasks_type']" wire:model="relatedEmployments.{{$key}}.tasks_type">
                                                <option value="bullets">Bullet Points</option>
                                                <option value="paragraph">Paragraph</option>
                                            </select>
                                            @error('relatedEmployments.'.$key.'.tasks_type')<span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div id="tasks-bullets-{{$key}}" class="tasks-bullets" @if ($employment['tasks_type'] == 'paragraph') style="display:none" @endif>
                                                <p class="mt-4"><span class="t18 fw600">Tasks / Duties / Responsibilities.</span>
                                                <ul id="sortable-employments-tasks" class="drag-list tasks">
                                                    @foreach($employment['tasks'] as $keyTask => $task)

                                                    <li id="{{$key}}-{{$keyTask}}" class="drag-box mb-0" wire:key="employment-task-{{$key}}-{{$keyTask}}">
                                                        <div class="row align-items-center pb-2 border-bottom">
                                                            <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>

                                                            <div class="col-md-9">
                                                                <div class="form-inline">
                                                                    <label class="mr-2">Task / duty description</label>
                                                                    <input type="text" class="form-control form-control-lg flex-grow-1 lazy_element" maxlength="255" placeholder="Description" name="relatedEmployments[{{$key}}]['tasks'][{{$keyTask}}]['description']" wire:model.defer="relatedEmployments.{{$key}}.tasks.{{$keyTask}}.description">
                                                                    @error('relatedEmployments.'.$key.'.tasks.'.$keyTask.'.description')<span class="text-danger error">{{ $message }}</span>@enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-auto ml-auto">
                                                                <button class="btn btn-danger" wire:click.prevent="removeRelatedEmploymentTasks({{$key}}, {{$keyTask}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                                                            </div>

                                                        </div>

                                                    </li>

                                                    @endforeach

                                                </ul>

                                                <button class="btn platform-button add-item my-4" wire:click.prevent="addRelatedEmploymentTask({{$key}})" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a task (bullet point)</button>
                                            </div>


                                            <div id="tasks-paragraph-{{$key}}" class="tasks-paragraph" @if ($employment['tasks_type'] == 'bullets')style="display:none"@endif>
                                                <div class="form-group">
                                                <p class="mt-4 mb-2"><span class="t18 fw600">Tasks / Duties / Responsibilities description.</span></p>
                                                    {!! Form::textarea("relatedEmployments[".$key."]['tasks_txt']", NULL, array('placeholder' => 'Tasks Text', 'class' => 'form-control form-control-lg', 'cols' => 40, 'rows' => 5, 'name' => "relatedEmployments[".$key."]['tasks_txt']", 'wire:model' => "relatedEmployments.".$key.".tasks_txt")) !!}
                                                    <div class="t14 mt-2">Using a short paragraph, describe the main tasks, duties and responsibilities you did or do as part of your role.</div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="col-auto ml-auto">
                                    <button class="btn btn-danger" wire:click.prevent="removeRelatedEmployment({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>

                        </li>
                        @endforeach
                    </ul>
                    <button class="btn platform-button add-item" wire:click.prevent="addRelatedEmployment()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a job or role</button>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <a class="examples-link" data-toggle="collapse" href="#pp-example" role="button" aria-expanded="false" aria-controls="pp-example">For inspiration, advice and ideas for your employment history - Click here to see some examples.</a>

                        <div class="collapse" id="pp-example">
                            <div class="example-text">
                            {!! $staticContent['cv_tasks_example'] !!}
                            </div>
                        </div>
                    </div>
                </div>



            {{-- else if has no employment--}}
            @else
                <h3 class="t20 fw600">Key Skills</h3>

                <div class="rounded p-4 cv-dyn-item">
                    <ul id="sortable-employment-skills" class="drag-list">
                    @foreach($relatedEmploymentSkills as $key => $employmentSkill)
                        <li id="{{$key}}" class="drag-box" wire:key="employment-skills-{{ $key }}">
                            <div class="row">
                                <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>


                                <div class="col-lg-4">

                                        <label>Skill Title</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Skill Title" name="relatedEmploymentSkills[{{$key}}]['title']" wire:model.defer="relatedEmploymentSkills.{{$key}}.title">
                                        @error('relatedEmploymentSkills.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror

                                </div>
                                <div class="col-lg-6 pb-3">

                                        <label>Skill Description</label>
                                        {!! Form::textarea("relatedEmploymentSkills[".$key."]['description']", NULL, array('placeholder' => 'Skill Description', 'class' => 'form-control form-control-lg', 'cols' => 80, 'rows' => 3, 'name' => "relatedEmploymentSkills[".$key."]['description']", 'wire:model' => "relatedEmploymentSkills.".$key.".description")) !!}
                                        @error('relatedEmploymentSkills.'.$key.'.description')<div class="text-danger error">{{ $message }}</div>@enderror

                                </div>

                                <div class="col-auto ml-auto">
                                    <button class="btn btn-danger" wire:click.prevent="removeRelatedEmploymentSkill({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>

                        </li>
                    @endforeach
                    </ul>
                    <button class="btn platform-button add-item" wire:click.prevent="addRelatedEmploymentSkill()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a Key Skill</button>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <a class="examples-link" data-toggle="collapse" href="#pp-example" role="button" aria-expanded="false" aria-controls="pp-example">For inspiration, advice and ideas for your key skills - Click here to see some examples.</a>

                        <div class="collapse" id="pp-example">
                            <div class="example-text">
                            {!! $staticContent['cv_key_skills_example'] !!}
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            </div>
        </div>
    </div>



    <div class="row justify-content-between mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('personal-profile')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('education')" wire:loading.attr="disabled" class="btn platform-button">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>

</div>





@push('scripts')
<script>


document.addEventListener('DOMContentLoaded', () => {

    function sortEmployment()
    {
        var sortedIDs = $("#sortable-employments").sortable({
            update: function (event, ui) {
                var employmentOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_employments_order', employmentOrder)
            }
        });

        $("#sortable-employments").disableSelection();


        var sortedIDs = $(".tasks").sortable({
            update: function (event, ui) {
                var employmentTasksOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_employments_tasks_order', employmentTasksOrder)
            }
        });

        $(".tasks").disableSelection();


        var sortedIDs = $("#sortable-employment-skills").sortable({
            update: function (event, ui) {
                var employmentSkillsOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_employment_skills_order', employmentSkillsOrder)
            }
        });

        $("#sortable-employment-skills").disableSelection();

    }

    sortEmployment();

    Livewire.hook('element.updated', () => {
        sortEmployment();
    });


   /*  $(document).on('change', '.tasks_type', function (e) {

         if ($(this).val() == 'paragraph')
        {
            $(this).closest('div.parent-bullet-para').next().find('.tasks-bullets').hide();
            $(this).closest('div.parent-bullet-para').next().find('.tasks-paragraph').show();
        } else {
            $(this).closest('div.parent-bullet-para').next().find('.tasks-bullets').show();
            $(this).closest('div.parent-bullet-para').next().find('.tasks-paragraph').hide();
        }
    }); */

});

</script>
@endpush
