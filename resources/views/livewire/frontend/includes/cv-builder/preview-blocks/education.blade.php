@if (count($relatedEducations) > 0)

    <div class="row">
        <div class="col">
            <div class="page-break-info">
                <div class="row align-items-center">
                    <div class="col-auto"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-format-page-break" width="32" height="32" viewBox="0 0 24 24"><path fill="#666" d="M18,20H6V18H4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V18H18V20M14,2H6A2,2 0 0,0 4,4V12H6V4H14V8H18V12H20V8L14,2M11,16H8V14H11V16M16,16H13V14H16V16M3,14H6V16H3V14M21,16H18V14H21V16Z" /></svg></div>
                    <div class="col">
                        <div class="form-group form-check mb-0">
                            {!! Form::checkbox('add_page_break_before_education', "Y", $addPageBreakBeforeEducation, ['class' => 'form-check-input mt-2', 'id' => 'add_page_break_before_education', 'wire:model.defer' => 'addPageBreakBeforeEducation' ]) !!}
                            <label class="form-check-label ml-1" for="add_page_break_before_education">Insert a page break <b>HERE</b></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
    </div>

    @foreach($relatedEducations as $relatedEducation)
        <div class="mb-3">
            <div class="row">
                @if ($relatedEducation['name'])
                <div class="col-6 fw600">{{$relatedEducation['name']}}</div>@endif
                <div class="col-1 fw600">Grade</div>
                <div class="col-auto fw600 ml-auto">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
            </div>

            @foreach($relatedEducation['grades'] as $grade)
                <div class="row justify-content-between">
                    <div class="col-6">@if ($grade['title']) {{$grade['title']}} @endif</div>
                    <div class="col-6">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                </div>
            @endforeach
        </div>
    @endforeach

@endif
