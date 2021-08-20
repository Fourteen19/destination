<div id="references" class="tab-pane @if ($activeTab == "references") active @else fade @endif">

    <div class="row">
        <div class="col-xl-8">

            <div class="rounded p-4 form-outer">
                <ul id="sortable-references" class="drag-list">
                @foreach($relatedReferences as $key => $reference)
                    <li id="{{$key}}" class="drag-box" wire:key="reference-{{ $key }}">
                        <div class="row">
                            <div class="col-md-1"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>


                            <div class="col-md-4">
                                <div class="form-inline">
                                    <label class="mr-2">Name</label>
                                    <input type="text" class="form-control lazy_element" placeholder="Name" name="relatedReferences[{{$key}}]['name']" wire:model.defer="relatedReferences.{{$key}}.name">
                                    @error('relatedReferences.'.$key.'.name')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Job Role:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Job Role" name="relatedReferences[{{$key}}]['job_role']" wire:model.defer="relatedReferences.{{$key}}.job_role">
                                    @error('relatedReferences.'.$key.'.job_role')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Company:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Company" name="relatedReferences[{{$key}}]['company']" wire:model.defer="relatedReferences.{{$key}}.company">
                                    @error('relatedReferences.'.$key.'.company')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Address Line 1:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Address Line 1" name="relatedReferences[{{$key}}]['address_1']" wire:model.defer="relatedReferences.{{$key}}.address_1">
                                    @error('relatedReferences.'.$key.'.address_1')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Address Line 2:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Address Line 2" name="relatedReferences[{{$key}}]['address_2']" wire:model.defer="relatedReferences.{{$key}}.address_2">
                                    @error('relatedReferences.'.$key.'.address_2')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Address Line 3:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Address Line 1" name="relatedReferences[{{$key}}]['address_3']" wire:model.defer="relatedReferences.{{$key}}.address_3">
                                    @error('relatedReferences.'.$key.'.address_3')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Postcode:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Postcode" name="relatedReferences[{{$key}}]['postcode']" wire:model.defer="relatedReferences.{{$key}}.postcode">
                                    @error('relatedReferences.'.$key.'.postcode')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Tel:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Tel" name="relatedReferences[{{$key}}]['phone']" wire:model.defer="relatedReferences.{{$key}}.phone">
                                    @error('relatedReferences.'.$key.'.phone')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Email:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Email" name="relatedReferences[{{$key}}]['email']" wire:model.defer="relatedReferences.{{$key}}.email">
                                    @error('relatedReferences.'.$key.'.email')<span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-1 ml-auto">
                                <button class="btn btn-danger" wire:click.prevent="removeRelatedReference({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                    </li>
                @endforeach
                </ul>
                <button class="mydir-action btn" wire:click.prevent="addRelatedReference()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a reference</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('additional-interests')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Previous</button>
        </div>
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('templates')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Next</button>
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
