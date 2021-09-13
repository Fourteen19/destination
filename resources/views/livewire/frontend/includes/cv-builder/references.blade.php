<div id="references" class="tab-pane @if ($activeTab == "references") active @else fade @endif">

    <div class="row">
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
                                        <label>Persons full name</label>
                                        <input type="text" class="form-control form-control-lg lazy_element" placeholder="Name" name="relatedReferences[{{$key}}]['name']" wire:model.defer="relatedReferences.{{$key}}.name">
                                        @error('relatedReferences.'.$key.'.name')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">The name of the person providing your reference e.g. Jane Smith.</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Job Title:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Job Role" name="relatedReferences[{{$key}}]['job_role']" wire:model.defer="relatedReferences.{{$key}}.job_role">
                                        @error('relatedReferences.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">Provide their job title e.g. Managing Director.</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Company / Business Name:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Company" name="relatedReferences[{{$key}}]['company']" wire:model.defer="relatedReferences.{{$key}}.company">
                                        @error('relatedReferences.'.$key.'.company')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">Provide the name of the business e.g. Big Company Ltd.</div>
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
                                        <div class="t14 mt-2">Provide the company postcode.</div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Tel:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Tel" name="relatedReferences[{{$key}}]['phone']" wire:model.defer="relatedReferences.{{$key}}.phone">
                                        @error('relatedReferences.'.$key.'.phone')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">Provide the company telephone number.</div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="mr-2">Email:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Email" name="relatedReferences[{{$key}}]['email']" wire:model.defer="relatedReferences.{{$key}}.email">
                                        @error('relatedReferences.'.$key.'.email')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2">Provide an email address.</div>
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
                <button class="btn platform-button add-item" wire:click.prevent="addRelatedReference()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a reference</button>
            </div>

            

            <div class="row">
                    <div class="col-12">
                        <a class="examples-link" data-toggle="collapse" href="#ref-example" role="button" aria-expanded="false" aria-controls="ref-example">For inspiration, advice and ideas for your references - Click here to see some examples.</a>

                        <div class="collapse" id="ref-example">
                            <div class="example-text">
                            {!! $staticContent['cv_references_example'] !!}
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
