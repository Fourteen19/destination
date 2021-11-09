
{{-- @if ( ($this->hasEmployment == "N") && (count($relatedEmploymentSkills) > 0) ) --}}

    @if (count($relatedEmploymentSkills) > 0)

    <div class="row">
        <div class="col">
            <div class="page-break-info">
                <div class="row align-items-center">
                    <div class="col-auto"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-format-page-break" width="32" height="32" viewBox="0 0 24 24"><path fill="#666" d="M18,20H6V18H4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V18H18V20M14,2H6A2,2 0 0,0 4,4V12H6V4H14V8H18V12H20V8L14,2M11,16H8V14H11V16M16,16H13V14H16V16M3,14H6V16H3V14M21,16H18V14H21V16Z" /></svg></div>
                    <div class="col">
                        <div class="form-group form-check mb-0">
                            {!! Form::checkbox('add_page_break_before_employment', "Y", $addPageBreakBeforeEmployment, ['class' => 'form-check-input mt-2', 'id' => 'add_page_break_before_employment', 'wire:model.defer' => 'addPageBreakBeforeEmployment' ]) !!}
                            <label class="form-check-label ml-1" for="add_page_break_before_employment">Insert a page break <b>HERE</b></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 fw600"><div class="cv-inner-heading">Key skills</div></div>
    </div>
    <div class="row mb-3">
    @foreach($relatedEmploymentSkills as $keySkill => $skill)
        <div class="col-12"><span class="fw600">{{$skill['title']}}</span>: {{$skill['description']}}</div>
    @endforeach
    </div>
@endif
