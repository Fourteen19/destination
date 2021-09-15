<div id="preview" class="tab-pane @if ($activeTab == "preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

            @if ($template == 1)

            <h2 class="fw700 t18">You have selected Template 1</h2>

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
                            <div class="col-12 fw600"><div class="cv-inner-heading">Skills and experience</div></div>
                        </div>
                        <div class="mb-3">
                            <div class="row justify-content-between">
                                <div class="col-auto fw600">Company name</div>
                                <div class="col-auto fw600">Sept 2020 - April 2021</div>
                            </div>
                            <div class="row">
                                <div class="col-12 fw600">Job title with bullets</div>
                                <div class="col-12">
                                    <ul>
                                        <li>Bullet point one</li>
                                        <li>Second bullet point</li>
                                        <li>The third bullet point</li>
                                        <li>Lastly the fourth point</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row justify-content-between">
                                <div class="col-auto fw600">Company name (Work Experience)</div>
                                <div class="col-auto fw600">Sept 2020 - April 2021</div>
                            </div>
                            <div class="row">
                                <div class="col-12 fw600">Job title with paragraph</div>
                                <div class="col-12">
                                    <p>Phasellus ut viverra justo. Nunc nec elit id neque venenatis pellentesque id vitae sapien. Aliquam erat volutpat. Vestibulum ut nulla interdum, fermentum augue vel, aliquam enim. Phasellus vitae sodales erat, ac convallis lorem. Morbi volutpat felis non rhoncus varius. Phasellus egestas eros et magna tempus, dapibus euismod mauris mollis. Quisque velit nunc, volutpat non dapibus id, hendrerit vel enim.</p>
                                </div>
                            </div>
                        </div>
                 
                 
                        <div class="row">
                            <div class="col-12 fw600"><div class="cv-inner-heading">Education</div></div>
                        </div>
                        @foreach($relatedEducations as $relatedEducation)
                        <div class="row justify-content-between">
                            @if ($relatedEducation['name'])<div class="col-8 fw600">{{$relatedEducation['name']}}</div>@endif
                            <div class="col-4 fw600"> @if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif - @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif</div>
                        </div>

                        @foreach($relatedEducation['grades'] as $grade)
                        <div class="row justify-content-between">
                        <div class="col-8">@if ($grade['title']) {{$grade['title']}} @endif</div>
                        @if ($grade['grade']) {{$grade['grade']}} @endif
                        @if ($grade['predicted']) {{$grade['predicted']}} @endif
                        </div>
                    @endforeach


                

                      
                   
                    

                    

                @endforeach




                @foreach($relatedReferences as $relatedReference)

                    @if ($relatedReference['name']) {{$relatedReference['name']}} @endif
                    @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} @endif
                    @if ($relatedReference['company']) {{$relatedReference['company']}} @endif
                    @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} @endif
                    @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} @endif
                    @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} @endif
                    @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} @endif
                    @if ($relatedReference['phone']) {{$relatedReference['phone']}} @endif
                    @if ($relatedReference['email']) {{$relatedReference['email']}} @endif

                @endforeach
                    </div>
                </div>
                

            @elseif ($template == 2)

            <h2>Template 2</h2>
                @if ($first_name) {{$first_name}} @endif
                @if ($last_name) {{$last_name}} @endif
                @if ($address) {{$address}} @endif
                @if ($email) {{$email}} @endif
                @if ($phone) {{$phone}} @endif
                @if ($personal_profile) {{$personal_profile}} @endif


            @elseif ($template == 3)
            <h2>Template 3</h2>
                @if ($first_name) {{$first_name}} @endif
                @if ($last_name) {{$last_name}} @endif


            @elseif ($template == 4)
            <h2>Template 4</h2>
            @elseif ($template == 5)
            <h2>Template 5</h2>
            @endif

        </div>
    </div>

    <div class="row mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('templates')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
    </div>

    
</div>

