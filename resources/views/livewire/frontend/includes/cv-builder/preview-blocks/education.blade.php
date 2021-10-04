@if (count($relatedEducations) > 0)

    <div class="row">
        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
    </div>

    @foreach($relatedEducations as $relatedEducation)
        <div class="mb-3">
            <div class="row">
                @if ($relatedEducation['name'])
                <div class="col-7 fw600">{{$relatedEducation['name']}}</div>@endif
                <div class="col-1 fw600">Grade</div>
                <div class="col-auto fw600 ml-auto">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
            </div>

            @foreach($relatedEducation['grades'] as $grade)
                <div class="row justify-content-between">
                    <div class="col-7">@if ($grade['title']) {{$grade['title']}} @endif</div>
                    <div class="col-5">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                </div>
            @endforeach
        </div>
    @endforeach

@endif
