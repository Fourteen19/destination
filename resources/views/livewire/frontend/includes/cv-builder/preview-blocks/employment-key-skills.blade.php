@if ( ($this->hasEmployment == "N") && (count($relatedEmploymentSkills) > 0) )

    <div class="row mt-3">
        <div class="col-12 fw600"><div class="cv-inner-heading">Key Skills</div></div>
    </div>
    <div class="row mb-3">
    @foreach($relatedEmploymentSkills as $keySkill => $skill)
        <div class="col-12"><span class="fw600">{{$skill['title']}}</span>: {{$skill['description']}}</div>
    @endforeach
    </div>
@endif
