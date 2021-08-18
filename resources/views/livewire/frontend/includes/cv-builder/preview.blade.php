<div>

    @if ($first_name) {{$first_name}} @endif
    @if ($last_name) {{$last_name}} @endif
    @if ($address) {{$address}} @endif
    @if ($email) {{$email}} @endif
    @if ($phone) {{$phone}} @endif
    @if ($personal_profile) {{$personal_profile}} @endif





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
