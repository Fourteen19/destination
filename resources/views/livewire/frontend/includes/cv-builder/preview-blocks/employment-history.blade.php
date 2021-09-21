@if (count($relatedEmployments) > 0)

    <div class="row mt-3">
        <div class="col-12 fw600"><div class="cv-inner-heading">{{$block_title}}</div></div>
    </div>

    @if ($hasEmployment == "Y")

        @foreach($relatedEmployments as $key => $employment)
            <div class="mb-3">
                <div class="row justify-content-between">
                    <div class="col-auto fw600">{{$employment['organisation']}} {{($employment['job_type'] == "employed") ? "" : ($employment['job_type'] == "work-experience" ? "(Work Experience)" : ($employment['job_type'] == "volunteering" ? "(Volunteering)" : ""))}}
                    </div>
                    <div class="col-auto fw600">{{$employment['from']}} - {{$employment['to']}}</div>
                </div>
                <div class="row">
                    <div class="col-12 fw600">{{$employment['job_role']}}</div>
                    <div class="col-12">
                        @if ($employment['tasks_type'] == "bullets")
                            <ul>
                                @foreach($employment['tasks'] as $keyTask => $task)
                                    <li>{{$task['description']}}</li>
                                @endforeach
                            </ul>
                        @elseif ($employment['tasks_type'] == "paragraph")
                            <p>{!! $employment['tasks_txt'] !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    @endif

@endif
