<div id="references" class="tab-pane @if ($activeTab == "references") active @else fade @endif">

    <div class="row mb-5">
        <div class="col-xl-12">

            {!! $staticContent['cv_references_instructions'] !!}

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
                                        <div class="t14 mt-2 font-italic">The name of the person providing your reference, for example, Mrs J Smith</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Job title:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Job title" name="relatedReferences[{{$key}}]['job_role']" wire:model.defer="relatedReferences.{{$key}}.job_role">
                                        @error('relatedReferences.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2 font-italic">Provide their job title, for example, Managing Director, Supervisor or Head of Year 11</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Company or school / college name:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Company or school / college name" name="relatedReferences[{{$key}}]['company']" wire:model.defer="relatedReferences.{{$key}}.company">
                                        @error('relatedReferences.'.$key.'.company')<span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="t14 mt-2 font-italic">Provide the name, for example, Big Company Ltd / Anytown High School etc</div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Address line 1:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Address line 1" name="relatedReferences[{{$key}}]['address_1']" wire:model.defer="relatedReferences.{{$key}}.address_1">
                                        @error('relatedReferences.'.$key.'.address_1')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Address line 2:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Address line 2" name="relatedReferences[{{$key}}]['address_2']" wire:model.defer="relatedReferences.{{$key}}.address_2">
                                        @error('relatedReferences.'.$key.'.address_2')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label>Address line 3:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Address line 3" name="relatedReferences[{{$key}}]['address_3']" wire:model.defer="relatedReferences.{{$key}}.address_3">
                                        @error('relatedReferences.'.$key.'.address_3')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Postcode:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Postcode" name="relatedReferences[{{$key}}]['postcode']" wire:model.defer="relatedReferences.{{$key}}.postcode">
                                        @error('relatedReferences.'.$key.'.postcode')<span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label>Phone number:</label>
                                        <input type="text" class="form-control form-control-lg drag-input" placeholder="Phone number" name="relatedReferences[{{$key}}]['phone']" wire:model.defer="relatedReferences.{{$key}}.phone">
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