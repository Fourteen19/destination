<div id="education" class="tab-pane @if ($activeTab == "education") active @else fade @endif">

    <div class="row">
        <div class="col-xl-12">

            {!! $staticContent['cv_education_instructions'] !!}

            <div class="rounded p-4 cv-dyn-item">

                <ul id="sortable-educations" class="drag-list">
                    @foreach($relatedEducations as $key => $education)
                    <li id="{{$key}}" class="drag-box" wire:key="education-{{ $key }}">
                        <div class="row align-items-start">
                            <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>

                            <div class="col-lg-10">
                                <div class="row">

                                    <div class="col-md-4 mb-4">
                                        <label>Name of school, college or university:</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Name of school, college or university" name="relatedEducations[{{$key}}]['name']" wire:model.defer="relatedEducations.{{$key}}.name">
                                        @error('relatedEducations.'.$key.'.name')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Date you attended from:</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="50" placeholder="From" name="relatedEducations[{{$key}}]['from']" wire:model.defer="relatedEducations.{{$key}}.from">
                                        @error('relatedEducations.'.$key.'.from')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2 font-italic">When did you start there, for example September 2018</div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Date you attended to:</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="50" placeholder="To" name="relatedEducations[{{$key}}]['to']" wire:model.defer="relatedEducations.{{$key}}.to">
                                        @error('relatedEducations.'.$key.'.to')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2 font-italic">When did you leave, for example, July 2020. If you still attend, enter the word "Present"</div>
                                    </div>


                                    <div class="col-12"><p><span class="t18 fw600">Your qualifications and grades</span></p></div>


                            <div class="col-12 mb-4">
                                <ul id="sortable-educations-grades" class="drag-list grades">
                                    @foreach($education['grades'] as $keyGrade => $grade)
                                {{-- <ul id="sortable-educations-grades-{{$loop->iteration}}" class="drag-list grades"> --}}

                                    {{-- <li class="drag-box item"> --}}
                                    <li id="{{$key}}-{{$keyGrade}}" class="drag-box mb-0" wire:key="education-grade-{{$key}}-{{$keyGrade}}">
                                        <div class="row align-items-start">
                                            <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-md-4 mb-4">
                                                        <label>Qualification:</label>
                                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Title" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['title']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.title">
                                                        @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.title')<span class= "text-danger error">{{ $message }}</span>@enderror
                                                        <div class="t14 mt-2 font-italic">For example: GCSE English</div>
                                                    </div>

                                                    <div class="col-md-4 mb-4">
                                                        <label>Grade:</label>
                                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="20" placeholder="Grade" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['grade']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.grade">
                                                        @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.grade')<span class="text-danger error">{{ $message }}</span>@enderror
                                                        <div class="t14 mt-2 font-italic">For example: 8 or Merit</div>
                                                    </div>

                                                    <div class="col-md-4 mb-4">

                                                        <label>Is it predicted?:</label>
                                                        <select class="form-control form-control-lg" name="tasks_type" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['predicted']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.predicted">
                                                            <option value="Y">Yes</option>
                                                            <option value="N">No</option>
                                                        </select>
                                                        @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.predicted')<span class="text-danger error">{{ $message }}</span>@enderror

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1 ml-auto">
                                                <button class="btn btn-danger" wire:click.prevent="removeRelatedEducationGrades({{$key}}, {{$keyGrade}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                                            </div>

                                        </div>

                                    </li>

                                    @endforeach

                                </ul>

                                        <button class="btn platform-button add-item" wire:click.prevent="addRelatedEducationGrade({{$key}})" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a qualification</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto ml-auto">
                                <button class="btn btn-danger" wire:click.prevent="removeRelatedEducation({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                    </li>
                    @endforeach
                </ul>
                <button class="btn platform-button add-item" wire:click.prevent="addRelatedEducation()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a school or college</button>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <a class="examples-link" data-toggle="collapse" href="#ed-example" role="button" aria-expanded="false" aria-controls="ed-example">Click here for advice and ideas about what to include in the education section of your CV.</a>

                    <div class="collapse" id="ed-example">
                        <div class="example-text">
                        {!! $staticContent['cv_education_example'] !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row justify-content-between mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('employment')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('additional-interests')" wire:loading.attr="disabled" class="btn platform-button">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>



</div>






@push('scripts')
<script>


document.addEventListener('DOMContentLoaded', () => {

    function sortEducation()
    {
        var sortedIDs = $("#sortable-educations").sortable({
            update: function (event, ui) {
                var educationOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_educations_order', educationOrder)
            }
        });

        $("#sortable-educations").disableSelection();


        var sortedIDs = $(".grades").sortable({
            update: function (event, ui) {
                var educationGradesOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_educations_grades_order', educationGradesOrder)
            }
        });

        $(".grades").disableSelection();

    }

    sortEducation();

    Livewire.hook('element.updated', () => {
        sortEducation();
    });

});

</script>
@endpush
