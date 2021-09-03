<div id="employment" class="tab-pane @if ($activeTab == "employment") active @else fade @endif">

    <div class="row">
        <div class="col-xl-12">

            <div class="px-lg-4">
                <div class="mb-3">{{ $staticContent['cv_experience_instructions'] }}</div>
            
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

                <div class="rounded p-4 form-outer">
                    <ul id="sortable-employments" class="drag-list">
                        @foreach($relatedEmployments as $key => $employment)
                        <li id="{{$key}}" class="drag-box" wire:key="employment-{{ $key }}">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="drag-handle"><i class="fas fa-arrows-alt"></i></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <label class="mr-2">Employer / Organisation Name</label>
                                        <input type="text" class="form-control lazy_element" placeholder="Employer / Organisation Name" name="relatedEmployments[{{$key}}]['organisation']" wire:model.defer="relatedEmployments.{{$key}}.organisation">
                                        @error('relatedEmployments.'.$key.'.organisation')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <label class="mr-2">Job / Role Title</label>
                                        <input type="text" class="form-control lazy_element" placeholder="Job / Role Title:" name="relatedEmployments[{{$key}}]['job_role']" wire:model.defer="relatedEmployments.{{$key}}.job_role">
                                        @error('relatedEmployments.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <label class="mr-2">Were you</label>
                                        <select class="form-control form-control-lg" name="relatedEmployments[{{$key}}]['job_type']" wire:model.defer="relatedEmployments.{{$key}}.job_type">
                                            <option value="employed">Employed</option>
                                            <option value="work-experience">Work Experienc</option>
                                            <option value="volunteering">Volunteering</option>
                                        </select>
                                        @error('relatedEmployments.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <label class="mr-2">From</label>
                                        <input type="text" class="form-control lazy_element" placeholder="From" name="relatedEmployments[{{$key}}]['from']" wire:model.defer="relatedEmployments.{{$key}}.from">
                                        @error('relatedEmployments.'.$key.'.from')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <label class="mr-2">To</label>
                                        <input type="text" class="form-control lazy_element" placeholder="To" name="relatedEmployments[{{$key}}]['to']" wire:model.defer="relatedEmployments.{{$key}}.to">
                                        @error('relatedEmployments.'.$key.'.to')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="col-md-4 parent-bullet-para">
                                    <div class="form-inline">
                                        <label class="mr-2">Bullets or Paragraph</label>
                                        <select class="form-control form-control-lg tasks_type" name="tasks_type" name="relatedEmployments[{{$key}}]['tasks_type']" wire:model.defer="relatedEmployments.{{$key}}.tasks_type">
                                            <option value="bullets">Bullet Points</option>
                                            <option value="paragraph">Paragraph</option>
                                        </select>
                                        @error('relatedEmployments.'.$key.'.tasks_type')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div id="tasks-bullets-{{$key}}" class="tasks-bullets" @if ($relatedEmployments[$key]['tasks_type'] == 'paragraph') style="display:none" @endif>
                                    <ul id="sortable-employments-tasks" class="drag-list tasks">
                                        @foreach($employment['tasks'] as $keyTask => $task)

                                        <li id="{{$key}}-{{$keyTask}}" class="drag-box" wire:key="employment-task-{{$key}}-{{$keyTask}}">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <div class="drag-handle"><i class="fas fa-arrows-alt"></i></div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-inline">
                                                        <label class="mr-2">Description</label>
                                                        <input type="text" class="form-control lazy_element" placeholder="Description" name="relatedEmployments[{{$key}}]['tasks'][{{$key}}]['description']" wire:model.defer="relatedEmployments.{{$key}}.tasks.{{$keyTask}}.description">
                                                        @error('relatedEmployments.'.$key.'.tasks.'.$keyTask.'.description')<span class="text-danger error">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-1 ml-auto">
                                                    <button class="btn btn-danger" wire:click.prevent="removeRelatedEmploymentTasks({{$key}}, {{$keyTask}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                                                </div>

                                            </div>

                                        </li>

                                        @endforeach

                                    </ul>

                                    <button class="mydir-action btn" wire:click.prevent="addRelatedEmploymentTask({{$key}})" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a task</button>
                                </div>


                                <div id="tasks-paragraph-{{$key}}" class="tasks-paragraph" @if ($relatedEmployments[$key]['tasks_type'] == 'bullets')style="display:none"@endif>
                                    <div class="form-group">
                                        {!! Form::label('tasks_txt', 'Tasks Text'); !!}
                                        {!! Form::textarea('tasks_txt', NULL, array('placeholder' => 'Tasks Text', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => "relatedEmployments[{{$key}}]['tasks_txt']")) !!}
                                        @error('tasks_txt') <div class="text-danger error">{{ $message }}</div>@enderror
                                    </div>
                                </div>


                                <div class="col-md-1 ml-auto">
                                    <button class="btn btn-danger" wire:click.prevent="removeRelatedEmployment({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>

                        </li>
                        @endforeach
                    </ul>
                    <button class="mydir-action btn" wire:click.prevent="addRelatedEmployment()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add an employment</button>
                </div>


                {!! $staticContent['cv_tasks_example'] !!}


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
                                    
                                        <label class="mr-2">Skill Title</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" placeholder="Skill Title" name="relatedEmploymentSkills[{{$key}}]['title']" wire:model.defer="relatedEmploymentSkills.{{$key}}.title">
                                        @error('relatedEmploymentSkills.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                                    
                                </div>
                                <div class="col-lg-4">
                                    
                                        <label class="mr-2">Skill Description</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" placeholder="Skill Description" name="relatedEmploymentSkills[{{$key}}]['description']" wire:model.defer="relatedEmploymentSkills.{{$key}}.description">
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
                        <a class="examples-link" data-toggle="collapse" href="#pp-example" role="button" aria-expanded="false" aria-controls="pp-example">Need some inspiration, advice and ideas? Click here to see some examples.</a>

                        <div class="collapse" id="pp-example">
                            <div class="example-text">
                            Key Skills Example Text
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


    $(document).on('change', '.tasks_type', function (e) {

        if ($(this).val() == 'paragraph')
        {
            $(this).closest('div.parent-bullet-para').next('div.tasks-bullets').hide();
            $(this).closest('div.parent-bullet-para').next().next('div.tasks-paragraph').show();
        } else {
            $(this).closest('div.parent-bullet-para').next('div.tasks-bullets').show();
            $(this).closest('div.parent-bullet-para').next().next('div.tasks-paragraph').hide();
        }
    });

});

</script>
@endpush
