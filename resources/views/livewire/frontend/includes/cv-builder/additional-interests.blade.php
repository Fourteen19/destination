<div id="additional-interests" class="tab-pane @if ($activeTab == "additional-interests") active @else fade @endif">
    <div class="row mb-5">
        <div class="col-lg-12">

            <div class="px-lg-4">
                <div class="mb-5">{{ $staticContent['cv_additional_interests_instructions'] }}</div>

                <div class="form-group row mb-3">
                    <div class="col-lg-2">{!! Form::label('additional_interests', 'Hobbies, interests and achievements:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::textarea('additional_interests', $this->additional_interests, array('placeholder' => 'Hobbies, interests and achievements', 'class' => 'form-control form-control-lg', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'additional_interests')) !!}
                    @error('additional_interests') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a class="examples-link" data-toggle="collapse" href="#ai-example" role="button" aria-expanded="false" aria-controls="ai-example">Click here for advice and ideas about what to include in the hobbies, interests and achievements section of your CV.</a>

                        <div class="collapse" id="ai-example">
                            <div class="example-text">
                            {!! $staticContent['cv_additional_interests_example'] !!}
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="page-break-info">
                <div class="row">
                    <div class="col-auto"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-format-page-break" width="32" height="32" viewBox="0 0 24 24"><path fill="#666" d="M18,20H6V18H4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V18H18V20M14,2H6A2,2 0 0,0 4,4V12H6V4H14V8H18V12H20V8L14,2M11,16H8V14H11V16M16,16H13V14H16V16M3,14H6V16H3V14M21,16H18V14H21V16Z" /></svg></div>
                    <div class="col">
                        <b>Add a page break before this section in your CV</b>
                        <p>It's best to make sure your CV fits on to two pages maximum. To make sure a section is breaks across two pages correctly, you can insert a page break before it. <b>Note:</b> You should only use this function once within your CV to avoid more than two pages.</p>
                        <div class="form-group form-check mb-0">
                            {!! Form::checkbox('page_break_before_additional_interests', "Y", $addPageBreakBeforeAdditionalInterest, ['class' => 'form-check-input mt-2', 'id' => 'page_break_before_additional_interests', 'wire:model.defer' => 'addPageBreakBeforeAdditionalInterest' ]) !!}
                            <label class="form-check-label ml-1" for="page_break_before_additional_interests">Insert a page break <b>BEFORE</b> this section</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-between mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('education')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('references')" wire:loading.attr="disabled" class="btn platform-button">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>

</div>
