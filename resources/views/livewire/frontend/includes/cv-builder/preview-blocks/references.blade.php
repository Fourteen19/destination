@if (count($relatedReferences) > 0)
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

@endif
