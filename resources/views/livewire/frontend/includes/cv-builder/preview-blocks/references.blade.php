@if (count($relatedReferences) > 0)

    <div class="row">
        <div class="col">
            <div class="page-break-info">
                <div class="row">
                    <div class="col-auto"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-format-page-break" width="32" height="32" viewBox="0 0 24 24"><path fill="#666" d="M18,20H6V18H4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V18H18V20M14,2H6A2,2 0 0,0 4,4V12H6V4H14V8H18V12H20V8L14,2M11,16H8V14H11V16M16,16H13V14H16V16M3,14H6V16H3V14M21,16H18V14H21V16Z" /></svg></div>
                    <div class="col">
                        <b>Add a page break before this section in your CV</b>
                        <p>It's best to make sure your CV fits on to two pages maximum. To make sure a section is breaks across two pages correctly, you can insert a page break before it. <b>Note:</b> You should only use this function once within your CV to avoid more than two pages.</p>
                        <div class="form-group form-check mb-0">
                            {!! Form::checkbox('page_break_before_references', "Y", $addPageBreakBeforeReferences, ['class' => 'form-check-input mt-2', 'id' => 'page_break_before_references', 'wire:model.defer' => 'addPageBreakBeforeReferences' ]) !!}
                            <label class="form-check-label ml-1" for="page_break_before_references">Insert a page break <b>BEFORE</b> this section</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
