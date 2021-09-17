<div id="preview" class="tab-pane @if ($activeTab == "preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

        @if ($template == 1)

            <h2 class="fw700 t18">You have selected "CV 1 (Modern)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    <div class="row">
                        <div class="col-12 text-center fw600">@if ($first_name) {{$first_name}} @endif  @if ($last_name) {{$last_name}} @endif</div>
                        @if ($address)<div class="col-12 text-center">{{$address}}</div>@endif
                        @if ($email)<div class="col-12 text-center">{{$email}}</div>@endif
                        @if ($phone)<div class="col-12 text-center">{{$phone}}</div>@endif
                    </div>

                    @if ($personal_profile)
                        <div class="row mt-3">
                            <div class="col-12 fw600">Personal Profile</div>
                            <div class="col-12">{{$personal_profile}}</div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Employment history</div></div>
                    </div>

                    @if ($this->hasEmployment == "Y")

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

                    @else
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    @if (count($relatedEmploymentSkills) > 0)
                                        @foreach($relatedEmploymentSkills as $keySkill => $skill)
                                            <p>{{$skill['title']}}</p>
                                            <p>{{$skill['description']}}</p>
                                        @endforeach
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
                    </div>

                    @foreach($relatedEducations as $relatedEducation)
                        <div class="mb-3">
                            <div class="row justify-content-between">
                                @if ($relatedEducation['name'])
                                <div class="col-auto fw600">{{$relatedEducation['name']}}</div>@endif
                                <div class="col-auto fw600">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
                            </div>

                            @foreach($relatedEducation['grades'] as $grade)
                                <div class="row justify-content-between">
                                    <div class="col-7">@if ($grade['title']) {{$grade['title']}} @endif</div>
                                    <div class="col-5">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Additional interests</div></div>
                        <div class="col-12"><p>{{$additional_interests}}</p></div>
                    </div>

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">References</div></div>
                    </div>

                    <div class="row">


                    @foreach($relatedReferences as $relatedReference)
                        <div class="col-lg-6">
                        @if ($relatedReference['name']) {{$relatedReference['name']}} @endif<br>
                        @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} @endif<br>
                        @if ($relatedReference['company']) {{$relatedReference['company']}} @endif<br>
                        @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} @endif<br>
                        @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} @endif<br>
                        @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} @endif<br>
                        @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} @endif<br>
                        @if ($relatedReference['phone']) {{$relatedReference['phone']}} @endif<br>
                        @if ($relatedReference['email']) {{$relatedReference['email']}} @endif
                        </div>
                    @endforeach

                    </div>

                        </div>
                    </div>


        @elseif ($template == 2)

        <h2 class="fw700 t18">You have selected "CV 2 (Modern)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    <div class="row">
                        <div class="col-12 text-center fw600">@if ($first_name) {{$first_name}} @endif  @if ($last_name) {{$last_name}} @endif</div>
                        @if ($address)<div class="col-12 text-center">{{$address}}</div>@endif
                        @if ($email)<div class="col-12 text-center">{{$email}}</div>@endif
                        @if ($phone)<div class="col-12 text-center">{{$phone}}</div>@endif
                    </div>

                    @if ($personal_profile)
                        <div class="row mt-3">
                            <div class="col-12 fw600">Personal Profile</div>
                            <div class="col-12">{{$personal_profile}}</div>
                        </div>
                    @endif


                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Key Skills</div></div>
                    </div>

                    <div class="row mb-3">
                    <div class="col-12"><span class="fw600">Key skill title</span>:- Key skill description nunc eros odio, pellentesque vel fringilla vitae, semper sit amet diam. Vivamus eleifend lacus ac odio interdum, nec porttitor erat eleifend.</div>
                    </div>

                    {{--
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
                    --}}


                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
                    </div>

                    @foreach($relatedEducations as $relatedEducation)
                        <div class="mb-3">
                            <div class="row justify-content-between">
                                @if ($relatedEducation['name'])
                                <div class="col-auto fw600">{{$relatedEducation['name']}}</div>@endif
                                <div class="col-auto fw600">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
                            </div>

                            @foreach($relatedEducation['grades'] as $grade)
                                <div class="row justify-content-between">
                                    <div class="col-7">@if ($grade['title']) {{$grade['title']}} @endif</div>
                                    <div class="col-5">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Additional interests</div></div>
                        <div class="col-12"><p>{{$additional_interests}}</p></div>
                    </div>

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">References</div></div>
                    </div>

                    <div class="row">


                    @foreach($relatedReferences as $relatedReference)
                        <div class="col-lg-6">
                        @if ($relatedReference['name']) {{$relatedReference['name']}} @endif<br>
                        @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} @endif<br>
                        @if ($relatedReference['company']) {{$relatedReference['company']}} @endif<br>
                        @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} @endif<br>
                        @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} @endif<br>
                        @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} @endif<br>
                        @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} @endif<br>
                        @if ($relatedReference['phone']) {{$relatedReference['phone']}} @endif<br>
                        @if ($relatedReference['email']) {{$relatedReference['email']}} @endif
                        </div>
                    @endforeach

                    </div>

                        </div>
                    </div>


        @elseif ($template == 3)
        <h2 class="fw700 t18">You have selected "CV 3 (Modern)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner">

                    <div class="row">
                        <div class="col-12 text-center fw600">@if ($first_name) {{$first_name}} @endif  @if ($last_name) {{$last_name}} @endif</div>
                        @if ($address)<div class="col-12 text-center">{{$address}}</div>@endif
                        @if ($email)<div class="col-12 text-center">{{$email}}</div>@endif
                        @if ($phone)<div class="col-12 text-center">{{$phone}}</div>@endif
                    </div>

                    @if ($personal_profile)
                        <div class="row mt-3">
                            <div class="col-12 fw600">Personal Profile</div>
                            <div class="col-12">{{$personal_profile}}</div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
                    </div>

                    @foreach($relatedEducations as $relatedEducation)
                        <div class="mb-3">
                            <div class="row justify-content-between">
                                @if ($relatedEducation['name'])
                                <div class="col-auto fw600">{{$relatedEducation['name']}}</div>@endif
                                <div class="col-auto fw600">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
                            </div>

                            @foreach($relatedEducation['grades'] as $grade)
                                <div class="row justify-content-between">
                                    <div class="col-7">@if ($grade['title']) {{$grade['title']}} @endif</div>
                                    <div class="col-5">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Work Experience</div></div>
                    </div>

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





                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Additional interests</div></div>
                        <div class="col-12"><p>{{$additional_interests}}</p></div>
                    </div>

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">References</div></div>
                    </div>

                    <div class="row">


                    @foreach($relatedReferences as $relatedReference)
                        <div class="col-lg-6">
                        @if ($relatedReference['name']) {{$relatedReference['name']}} @endif<br>
                        @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} @endif<br>
                        @if ($relatedReference['company']) {{$relatedReference['company']}} @endif<br>
                        @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} @endif<br>
                        @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} @endif<br>
                        @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} @endif<br>
                        @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} @endif<br>
                        @if ($relatedReference['phone']) {{$relatedReference['phone']}} @endif<br>
                        @if ($relatedReference['email']) {{$relatedReference['email']}} @endif
                        </div>
                    @endforeach

                    </div>

                        </div>
                    </div>


        @elseif ($template == 4)
        <h2 class="fw700 t18">You have selected "CV 4 (Traditional)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner" style="font-family: serif">

                    <div class="row">
                        <div class="col-12 text-center fw600">@if ($first_name) {{$first_name}} @endif  @if ($last_name) {{$last_name}} @endif</div>
                        @if ($address)<div class="col-12 text-center">{{$address}}</div>@endif
                        @if ($email)<div class="col-12 text-center">{{$email}}</div>@endif
                        @if ($phone)<div class="col-12 text-center">{{$phone}}</div>@endif
                    </div>

                    @if ($personal_profile)
                        <div class="row mt-3">
                            <div class="col-12 fw600">Personal Profile</div>
                            <div class="col-12">{{$personal_profile}}</div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Employment history</div></div>
                    </div>

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



                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
                    </div>

                    @foreach($relatedEducations as $relatedEducation)
                        <div class="mb-3">
                            <div class="row justify-content-between">
                                @if ($relatedEducation['name'])
                                <div class="col-auto fw600">{{$relatedEducation['name']}}</div>@endif
                                <div class="col-auto fw600">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
                            </div>

                            @foreach($relatedEducation['grades'] as $grade)
                                <div class="row justify-content-between">
                                    <div class="col-7">@if ($grade['title']) {{$grade['title']}} @endif</div>
                                    <div class="col-5">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Additional interests</div></div>
                        <div class="col-12"><p>{{$additional_interests}}</p></div>
                    </div>

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">References</div></div>
                    </div>

                    <div class="row">


                    @foreach($relatedReferences as $relatedReference)
                        <div class="col-lg-6">
                        @if ($relatedReference['name']) {{$relatedReference['name']}} @endif<br>
                        @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} @endif<br>
                        @if ($relatedReference['company']) {{$relatedReference['company']}} @endif<br>
                        @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} @endif<br>
                        @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} @endif<br>
                        @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} @endif<br>
                        @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} @endif<br>
                        @if ($relatedReference['phone']) {{$relatedReference['phone']}} @endif<br>
                        @if ($relatedReference['email']) {{$relatedReference['email']}} @endif
                        </div>
                    @endforeach

                    </div>

                        </div>
                    </div>
        @elseif ($template == 5)
        <h2 class="fw700 t18">You have selected "CV 5 (Traditional)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner" style="font-family: serif">

                    <div class="row">
                        <div class="col-12 text-center fw600">@if ($first_name) {{$first_name}} @endif  @if ($last_name) {{$last_name}} @endif</div>
                        @if ($address)<div class="col-12 text-center">{{$address}}</div>@endif
                        @if ($email)<div class="col-12 text-center">{{$email}}</div>@endif
                        @if ($phone)<div class="col-12 text-center">{{$phone}}</div>@endif
                    </div>

                    @if ($personal_profile)
                        <div class="row mt-3">
                            <div class="col-12 fw600">Personal Profile</div>
                            <div class="col-12">{{$personal_profile}}</div>
                        </div>
                    @endif


                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Key Skills</div></div>
                    </div>

                    <div class="row mb-3">
                    <div class="col-12"><span class="fw600">Key skill title</span>:- Key skill description nunc eros odio, pellentesque vel fringilla vitae, semper sit amet diam. Vivamus eleifend lacus ac odio interdum, nec porttitor erat eleifend.</div>
                    </div>

                    {{--
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
                    --}}


                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
                    </div>

                    @foreach($relatedEducations as $relatedEducation)
                        <div class="mb-3">
                            <div class="row justify-content-between">
                                @if ($relatedEducation['name'])
                                <div class="col-auto fw600">{{$relatedEducation['name']}}</div>@endif
                                <div class="col-auto fw600">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
                            </div>

                            @foreach($relatedEducation['grades'] as $grade)
                                <div class="row justify-content-between">
                                    <div class="col-7">@if ($grade['title']) {{$grade['title']}} @endif</div>
                                    <div class="col-5">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Additional interests</div></div>
                        <div class="col-12"><p>{{$additional_interests}}</p></div>
                    </div>

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">References</div></div>
                    </div>

                    <div class="row">


                    @foreach($relatedReferences as $relatedReference)
                        <div class="col-lg-6">
                        @if ($relatedReference['name']) {{$relatedReference['name']}} @endif<br>
                        @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} @endif<br>
                        @if ($relatedReference['company']) {{$relatedReference['company']}} @endif<br>
                        @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} @endif<br>
                        @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} @endif<br>
                        @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} @endif<br>
                        @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} @endif<br>
                        @if ($relatedReference['phone']) {{$relatedReference['phone']}} @endif<br>
                        @if ($relatedReference['email']) {{$relatedReference['email']}} @endif
                        </div>
                    @endforeach

                    </div>

                        </div>
                    </div>
        @elseif ($template == 6)
        <h2 class="fw700 t18">You have selected "CV 6 (Traditional)"</h2>
            <p class="t16">Note: The preview below is for information purposes only and your CV is shown as one continuous document. Your CV may break on to two or more pages when it is downloaded or printed from a PDF. You should not print this screen - to download your final CV, use the "Save & download as PDF" button at the bottom of the screen.</p>

            <div class="cv-preview-outer">
                <div class="cv-preview-inner" style="font-family: serif">

                    <div class="row">
                        <div class="col-12 text-center fw600">@if ($first_name) {{$first_name}} @endif  @if ($last_name) {{$last_name}} @endif</div>
                        @if ($address)<div class="col-12 text-center">{{$address}}</div>@endif
                        @if ($email)<div class="col-12 text-center">{{$email}}</div>@endif
                        @if ($phone)<div class="col-12 text-center">{{$phone}}</div>@endif
                    </div>

                    @if ($personal_profile)
                        <div class="row mt-3">
                            <div class="col-12 fw600">Personal Profile</div>
                            <div class="col-12">{{$personal_profile}}</div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
                    </div>

                    @foreach($relatedEducations as $relatedEducation)
                        <div class="mb-3">
                            <div class="row justify-content-between">
                                @if ($relatedEducation['name'])
                                <div class="col-auto fw600">{{$relatedEducation['name']}}</div>@endif
                                <div class="col-auto fw600">@if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
                            </div>

                            @foreach($relatedEducation['grades'] as $grade)
                                <div class="row justify-content-between">
                                    <div class="col-7">@if ($grade['title']) {{$grade['title']}} @endif</div>
                                    <div class="col-5">@if ($grade['grade']) {{$grade['grade']}} @endif @if ($grade['predicted'] == "Y") (predicted) @endif</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="row mt-3">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Work Experience</div></div>
                    </div>

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





                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">Additional interests</div></div>
                        <div class="col-12"><p>{{$additional_interests}}</p></div>
                    </div>

                    <div class="row">
                        <div class="col-12 fw600"><div class="cv-inner-heading">References</div></div>
                    </div>

                    <div class="row">


                    @foreach($relatedReferences as $relatedReference)
                        <div class="col-lg-6">
                        @if ($relatedReference['name']) {{$relatedReference['name']}} @endif<br>
                        @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} @endif<br>
                        @if ($relatedReference['company']) {{$relatedReference['company']}} @endif<br>
                        @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} @endif<br>
                        @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} @endif<br>
                        @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} @endif<br>
                        @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} @endif<br>
                        @if ($relatedReference['phone']) {{$relatedReference['phone']}} @endif<br>
                        @if ($relatedReference['email']) {{$relatedReference['email']}} @endif
                        </div>
                    @endforeach

                    </div>

                        </div>
                    </div>
        @endif

        </div>
    </div>

    <div class="row mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('templates')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
    </div>


</div>

