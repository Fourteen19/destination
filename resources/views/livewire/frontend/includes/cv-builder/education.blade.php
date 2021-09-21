<div id="education" class="tab-pane @if ($activeTab == "education") active @else fade @endif">

    <div class="row">
        <div class="col-xl-12">

            {{ $staticContent['cv_education_instructions'] }}

            <div class="rounded p-4 cv-dyn-item">

                <ul id="sortable-educations" class="drag-list">
                    @foreach($relatedEducations as $key => $education)
                    <li id="{{$key}}" class="drag-box" wire:key="education-{{ $key }}">
                        <div class="row align-items-start">
                            <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>

                            <div class="col-lg-10">
                                <div class="row">

                                    <div class="col-md-4 mb-4">
                                        <label>Name of school / college or university</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Name of school / college or university" name="relatedEducations[{{$key}}]['name']" wire:model.defer="relatedEducations.{{$key}}.name">
                                        @error('relatedEducations.'.$key.'.name')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Date you attended from</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="50" placeholder="From" name="relatedEducations[{{$key}}]['from']" wire:model.defer="relatedEducations.{{$key}}.from">
                                        @error('relatedEducations.'.$key.'.from')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">When did you start there e.g. September 2018.</div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Date you attended to</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="50" placeholder="To" name="relatedEducations[{{$key}}]['to']" wire:model.defer="relatedEducations.{{$key}}.to">
                                        @error('relatedEducations.'.$key.'.to')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">When did you leave e.g. July 2020. If you still attend, enter the word "Present"</div>
                                    </div>


                                    <div class="col-12"><p><span class="t18 fw600">Your qualifications / results.</span>
                                    <br>You can either list all your resposibilites and task as bullet points OR you can enter a short paragraph describing what you did in your role.</p></div>


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
                                                        <label>Qualification Title</label>
                                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="255" placeholder="Title" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['title']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.title">
                                                        @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.title')<span class= "text-danger error">{{ $message }}</span>@enderror
                                                        <div class="t14 mt-2">E.g. GCSE English</div>
                                                    </div>

                                                    <div class="col-md-4 mb-4">
                                                        <label>Grade / Result</label>
                                                        <input type="text" class="form-control form-control-lg lazy_element" maxlength="10" placeholder="Grade" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['grade']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.grade">
                                                        @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.grade')<span class="text-danger error">{{ $message }}</span>@enderror
                                                        <div class="t14 mt-2">E.g. 8</div>
                                                    </div>

                                                    <div class="col-md-4 mb-4">

                                                        <label>Is it predicted</label>
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

                                        <button class="btn platform-button add-item" wire:click.prevent="addRelatedEducationGrade({{$key}})" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a grade</button>
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
                <button class="btn platform-button add-item" wire:click.prevent="addRelatedEducation()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add an education</button>
            </div>

            <div class="row">
                <div class="col-12">
                    <a class="examples-link" data-toggle="collapse" href="#ed-example" role="button" aria-expanded="false" aria-controls="ed-example">For some inspiration, advice and ideas for your education history - Click here to see some examples.</a>

                    <div class="collapse" id="ed-example">
                        <div class="example-text">
                        {!! $staticContent['cv_education_example'] !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="page-break-info">
                <div class="row">
                    <div class="col-auto"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-format-page-break" width="32" height="32" viewBox="0 0 24 24"><path fill="#666" d="M18,20H6V18H4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V18H18V20M14,2H6A2,2 0 0,0 4,4V12H6V4H14V8H18V12H20V8L14,2M11,16H8V14H11V16M16,16H13V14H16V16M3,14H6V16H3V14M21,16H18V14H21V16Z" /></svg></div>
                    <div class="col">
                        <b>Add a page break before this section in your CV</b>
                        <p>It's best to make sure your CV fits on to two pages maximum. To make sure a section is breaks across two pages correctly, you can insert a page break before it. <b>Note:</b> You should only use this function once within your CV to avoid more than two pages.</p>
                        <div class="form-group form-check mb-0">
                            {!! Form::checkbox('add_page_break_before_education', "Y", $addPageBreakBeforeEducation, ['class' => 'form-check-input mt-2', 'id' => 'add_page_break_before_education', 'wire:model.defer' => 'addPageBreakBeforeEducation' ]) !!}
                            <label class="form-check-label ml-1" for="add_page_break_before_education">Insert a page break <b>BEFORE</b> this section</label>
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
