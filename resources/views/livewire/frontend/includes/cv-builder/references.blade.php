<div id="references" class="tab-pane @if ($activeTab == "references") active @else fade @endif">

    <div class="row mb-5">
        <div class="col-xl-12">

            {{ $staticContent['cv_references_instructions'] }}

            <div class="rounded p-4 cv-dyn-item">

                <ul id="sortable-references" class="drag-list">
                @foreach($relatedReferences as $key => $reference)
                    <li id="{{$key}}" class="drag-box" wire:key="reference-{{ $key }}">
                        <div class="row align-items-start">
                            <div class="col-auto"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                            <div class="col-lg-10">
                                <div class="row">

                                    <div class="col-lg-6 mb-4">
                                        <label>Name:</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" placeholder="Name" name="relatedReferences[{{$key}}]['name']" wire:model.defer="relatedReferences.{{$key}}.name">
                                        @error('relatedReferences.'.$key.'.name')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">The name of the person providing your reference e.g. Mrs J Smith.</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Job Title:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Job Role" name="relatedReferences[{{$key}}]['job_role']" wire:model.defer="relatedReferences.{{$key}}.job_role">
                                        @error('relatedReferences.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">Provide their job title e.g. Managing Director / Head of Year 11 etc.</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Company or school name:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Company" name="relatedReferences[{{$key}}]['company']" wire:model.defer="relatedReferences.{{$key}}.company">
                                        @error('relatedReferences.'.$key.'.company')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">Provide the name e.g. Big Company Ltd / Anytown High School etc.</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Address Line 1:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Address Line 1" name="relatedReferences[{{$key}}]['address_1']" wire:model.defer="relatedReferences.{{$key}}.address_1">
                                        @error('relatedReferences.'.$key.'.address_1')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Address Line 2:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Address Line 2" name="relatedReferences[{{$key}}]['address_2']" wire:model.defer="relatedReferences.{{$key}}.address_2">
                                        @error('relatedReferences.'.$key.'.address_2')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Address Line 3:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Address Line 1" name="relatedReferences[{{$key}}]['address_3']" wire:model.defer="relatedReferences.{{$key}}.address_3">
                                        @error('relatedReferences.'.$key.'.address_3')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Postcode:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Postcode" name="relatedReferences[{{$key}}]['postcode']" wire:model.defer="relatedReferences.{{$key}}.postcode">
                                        @error('relatedReferences.'.$key.'.postcode')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Tel:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Tel" name="relatedReferences[{{$key}}]['phone']" wire:model.defer="relatedReferences.{{$key}}.phone">
                                        @error('relatedReferences.'.$key.'.phone')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="mr-2">Email:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Email" name="relatedReferences[{{$key}}]['email']" wire:model.defer="relatedReferences.{{$key}}.email">
                                        @error('relatedReferences.'.$key.'.email')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                            </div>



                            <div class="col-auto ml-auto">
                                <button class="btn btn-danger" wire:click.prevent="removeRelatedReference({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                    </li>
                @endforeach
                </ul>

                {{-- we only allow 2 references - must indicate <=1,  <=2 does not work  --}}
                @if (count($relatedReferences) <= 1)
                    <button class="btn platform-button add-item" wire:click.prevent="addRelatedReference()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a reference</button>
                @endif
            </div>



            <div class="row">
                <div class="col-12">
                    <a class="examples-link" data-toggle="collapse" href="#ref-example" role="button" aria-expanded="false" aria-controls="ref-example">Click here for advice about who to include as references on your CV.</a>

                    <div class="collapse" id="ref-example">
                        <div class="example-text">
                        {!! $staticContent['cv_references_example'] !!}
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
                            {!! Form::checkbox('page_break_before_references', "Y", $addPageBreakBeforeReferences, ['class' => 'form-check-input mt-2', 'id' => 'page_break_before_references', 'wire:model.defer' => 'addPageBreakBeforeReferences' ]) !!}
                            <label class="form-check-label ml-1" for="page_break_before_references">Insert a page break <b>BEFORE</b> this section</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-between mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('additional-interests')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('templates')" wire:loading.attr="disabled" class="btn platform-button">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>

</div>


@push('scripts')
    <script>

    $( function() {
        var sortedIDs = $( "#sortable-references" ).sortable({
            update: function(event, ui) {
                var referenceOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_references_order', referenceOrder)
            }
        });

        $( "#sortable-references" ).disableSelection();

    } );

  </script>
@endpush
