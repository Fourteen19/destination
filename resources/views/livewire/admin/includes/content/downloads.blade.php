<div id="downloads" class="tab-pane px-0 @if ($activeTab == "downloads") active @else fade @endif" wire:key="downloads-pane">
    <div class="row">
        <div class="col-lg-12">

            <div class="rounded p-4 form-outer">
                <ul id="sortable-downloads" class="drag-list">
                    @foreach($relatedDownloads as $key => $relatedDownload)
                    <li id="{{$key}}" class="drag-box" wire:key="download-{{ $key }}">
                        <div class="row">
                            <div class="col-md-1"><div wire:sortable.handle class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>

                            <div class="col-md-5">
                                <div class="form-inline">
                                    <label class="mr-2">Enter the download title</label>
                                    <input type="text" class="form-control" placeholder="Enter title"  name="relatedDownloads[{{$key}}]['title']" wire:model.defer="relatedDownloads.{{$key}}.title">
                                    @error('relatedDownloads.'.$key.'.title')<div class="text-danger error">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-inline">
                                    <label class="mr-2">Select the file</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter URL" id="file_relatedDownloads[{{$key}}]['url']" name="relatedDownloads[{{$key}}]['url']" wire:model.lazy="relatedDownloads.{{$key}}.url" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary add-download" data-ref="file_relatedDownloads[{{$key}}]['url']" id="relatedDownloads_{{$key}}_url" type="button">Select</button>
                                        </div>
                                        @error('relatedDownloads.'.$key.'.url')<div class="text-danger error">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1 ml-auto">
                                <button class="btn btn-danger" wire:click.prevent="removeRelatedDownload({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                            </div>

                        </div>
                    </li>
                    @endforeach
                </ul>
                <button class="mydir-action btn" wire:click.prevent="addRelatedDownload()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a download</button>

            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>

    $(document).on('click', '.add-download', function() {;
        event.preventDefault();
        inputId = $(this).data("ref");
        window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
    });


    $( function() {
        var sortedIDs = $( "#sortable-downloads" ).sortable({
            update: function(event, ui) {
                var downloadOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_downloads_order', downloadOrder)
            }
        });

        $( "#sortable-downloads" ).disableSelection();

    } );
  </script>
@endpush
