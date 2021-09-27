@if (count($relatedReferences) > 0)
    <div class="row">
        <div class="col-12 fw600"><div class="cv-inner-heading">References</div></div>
    </div>

    <div class="row">

        @foreach($relatedReferences as $relatedReference)
            <div class="col-lg-6">
            @if ($relatedReference['name']) {{$relatedReference['name']}} <br> @endif
            @if ($relatedReference['job_role']) {{$relatedReference['job_role']}} <br> @endif
            @if ($relatedReference['company']) {{$relatedReference['company']}} <br> @endif
            @if ($relatedReference['address_1']) {{$relatedReference['address_1']}} <br> @endif
            @if ($relatedReference['address_2']) {{$relatedReference['address_2']}} <br> @endif
            @if ($relatedReference['address_3']) {{$relatedReference['address_3']}} <br> @endif
            @if ($relatedReference['postcode']) {{$relatedReference['postcode']}} <br> @endif
            @if ($relatedReference['phone']) {{$relatedReference['phone']}} <br> @endif
            @if ($relatedReference['email']) {{$relatedReference['email']}} @endif
            </div>
        @endforeach

    </div>

@endif
