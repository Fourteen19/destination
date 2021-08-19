<div id="preview" class="tab-pane @if ($activeTab == "preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            @if ($first_name) {{$first_name}} @endif
            @if ($last_name) {{$last_name}} @endif
            @if ($address) {{$address}} @endif
            @if ($email) {{$email}} @endif
            @if ($phone) {{$phone}} @endif
            @if ($personal_profile) {{$personal_profile}} @endif




            @foreach($relatedEducations as $relatedEducation)

                @if ($relatedEducation['name']) {{$relatedEducation['name']}} @endif
                @if ($relatedEducation['from']) {{$relatedEducation['from']}} @endif
                @if ($relatedEducation['to']) {{$relatedEducation['to']}} @endif

                @foreach($relatedEducation['grades'] as $grade)
                    @if ($grade['title']) {{$grade['title']}} @endif
                    @if ($grade['grade']) {{$grade['grade']}} @endif
                    @if ($grade['predicted']) {{$grade['predicted']}} @endif
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
</div>

