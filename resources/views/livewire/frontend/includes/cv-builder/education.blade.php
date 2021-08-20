<div id="education" class="tab-pane @if ($activeTab == "education") active @else fade @endif">

    <div class="row">
        <div class="col-xl-8">

            <div class="rounded p-4 form-outer">
                <ul id="sortable-educations" class="drag-list">
                    @foreach($relatedEducations as $key => $education)
                    <li id="{{$key}}" class="drag-box" wire:key="education-{{ $key }}">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="drag-handle"><i class="fas fa-arrows-alt"></i></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-inline">
                                    <label class="mr-2">Name of school / college or university</label>
                                    <input type="text" class="form-control lazy_element" placeholder="Name of school / college or university" name="relatedEducations[{{$key}}]['name']" wire:model.defer="relatedEducations.{{$key}}.name">
                                    @error('relatedEducations.'.$key.'.name')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-inline">
                                    <label class="mr-2">From</label>
                                    <input type="text" class="form-control lazy_element" placeholder="From" name="relatedEducations[{{$key}}]['from']" wire:model.defer="relatedEducations.{{$key}}.from">
                                    @error('relatedEducations.'.$key.'.from')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-inline">
                                    <label class="mr-2">To</label>
                                    <input type="text" class="form-control lazy_element" placeholder="To" name="relatedEducations[{{$key}}]['to']" wire:model.defer="relatedEducations.{{$key}}.to">
                                    @error('relatedEducations.'.$key.'.to')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div>
                                <ul id="sortable-educations-grades" class="drag-list grades">
                                    @foreach($education['grades'] as $keyGrade => $grade)
                                {{-- <ul id="sortable-educations-grades-{{$loop->iteration}}" class="drag-list grades"> --}}

                                    {{-- <li class="drag-box item"> --}}
                                    <li id="{{$key}}-{{$keyGrade}}" class="drag-box" wire:key="education-grade-{{$key}}-{{$keyGrade}}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="drag-handle"><i class="fas fa-arrows-alt"></i></div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-inline">
                                                    <label class="mr-2">Title</label>
                                                    <input type="text" class="form-control lazy_element" placeholder="Title" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['title']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.title">
                                                    @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-inline">
                                                    <label class="mr-2">Grade</label>
                                                    <input type="text" class="form-control lazy_element" placeholder="Grade" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['grade']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.grade">
                                                    @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.grade')<span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-inline">
                                                    <label class="mr-2">Predicted</label>
                                                    <select class="form-control form-control-lg" name="tasks_type" name="relatedEducations[{{$key}}]['grades'][{{$key}}]['predicted']" wire:model.defer="relatedEducations.{{$key}}.grades.{{$keyGrade}}.predicted">
                                                        <option value="Y">Yes</option>
                                                        <option value="N">No</option>
                                                    </select>
                                                    @error('relatedEducations.'.$key.'.grades.'.$keyGrade.'.predicted')<span class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                            </div>

                                            <div class="col-md-1 ml-auto">
                                                <button class="btn btn-danger" wire:click.prevent="removeRelatedEducationGrades({{$key}}, {{$keyGrade}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                                            </div>

                                        </div>

                                    </li>

                                    @endforeach

                                </ul>

                                <button class="mydir-action btn" wire:click.prevent="addRelatedEducationGrade({{$key}})" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a grade</button>
                            </div>


                            <div class="col-md-1 ml-auto">
                                <button class="btn btn-danger" wire:click.prevent="removeRelatedEducation({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                    </li>
                    @endforeach
                </ul>
                <button class="mydir-action btn" wire:click.prevent="addRelatedEducation()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add an education</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('employment')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Previous</button>
        </div>
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('additional-interests')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Next</button>
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
