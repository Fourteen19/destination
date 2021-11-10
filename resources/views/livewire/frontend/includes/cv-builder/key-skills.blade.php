<div id="key-skills" class="tab-pane @if ($activeTab == "key-skills") active @else fade @endif">

    <div class="row">
        <div class="col-xl-12">

            <div class="px-lg-4">
                <div class="mb-3">{!! $staticContent['cv_key_skills_instructions'] !!}</div>

                <div class="cv-split mb-5"></div>

                <h3 class="t20 fw600">Key skills</h3>

                <div class="rounded p-4 cv-dyn-item">
                    <ul id="sortable-employment-skills" class="drag-list">
                    @foreach($relatedEmploymentSkills as $key => $employmentSkill)
                        <li id="{{$key}}" class="drag-box" wire:key="employment-skills-{{ $key }}">
                            <div class="row">
                                <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>


                                <div class="col-lg-4">

                                        <label>Name of a skill(s) you want to add:</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Name of a skill(s) you want to add" name="relatedEmploymentSkills[{{$key}}]['title']" wire:model.defer="relatedEmploymentSkills.{{$key}}.title">
                                        @error('relatedEmploymentSkills.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2"><i>For example, 'Communication' or 'Numeracy and literacy'</i>.</div>

                                </div>
                                <div class="col-lg-6 pb-3">

                                        <label>Give an example to show you have this skill:</label>
                                        {!! Form::textarea("relatedEmploymentSkills[".$key."]['description']", NULL, array('placeholder' => 'Give an example to show you have this skill', 'class' => 'form-control form-control-lg', 'cols' => 80, 'rows' => 3, 'name' => "relatedEmploymentSkills[".$key."]['description']", 'wire:model' => "relatedEmploymentSkills.".$key.".description")) !!}
                                        @error('relatedEmploymentSkills.'.$key.'.description')<div class="text-danger error">{{ $message }}</div>@enderror
                                        <div class="t14 mt-2"><i>For example, 'At school I am good at listening to my teachers and other students and I also regularly contribute my ideas in class. I also gave a presentation to a Year 11 assembly about a climate change project I was involved in.'</i></div>

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
                        <a class="examples-link" data-toggle="collapse" href="#pp-example" role="button" aria-expanded="false" aria-controls="pp-example">Click here for advice and ideas about what to include as key skills in your CV.</a>

                        <div class="collapse" id="pp-example">
                            <div class="example-text">
                            {!! $staticContent['cv_key_skills_example'] !!}
                            </div>
                        </div>
                    </div>
                </div>

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
