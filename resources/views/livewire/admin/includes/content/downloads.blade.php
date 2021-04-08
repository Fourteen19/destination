<div id="downloads" class="tab-pane px-0 @if ($activeTab == "downloads") active @else fade @endif" wire:key="downloads-pane">
    <div class="row">
        <div class="col-lg-12">

            <div wire:sortable="updateGroupOrder" wire:sortable-group="updateDownloadsOrder" style="display: flex">
                <div wire:key="group-downloads" wire:sortable.item="downloads">

                    <div class="rounded p-4 form-outer">
                        <ul wire:sortable-group.item-group="downloads" class="drag-list">
                            @foreach($relatedDownloads as $key => $relatedDownload)
                            <li wire:sortable-group.item="{{ $key }}" wire:key="download-{{ $key }}" class="drag-box">
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
                                                    <button class="btn btn-outline-secondary" data-ref="file_relatedDownloads[{{$key}}]['url']" id="relatedDownloads_{{$key}}_url" type="button">Select</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @push('scripts')
                                        <script>
                                            {{-- adds listener for loaded downloads --}}
                                            document.addEventListener("DOMContentLoaded", function() {
                                                document.getElementById("relatedDownloads_{{$key}}_url").addEventListener('click', (event) => {
                                                    event.preventDefault();
                                                    inputId = "file_relatedDownloads[{{$key}}]['url']";
                                                    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                                                });
                                            });

                                        </script>
                                    @endpush

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
        </div>
    </div>
</div>


@push('scripts')
<script>

{{-- adds dynamic listener for added downloads --}}
$(document).on('click', '.add-download', function() {
    //console.log($(this).data("ref"));
    event.preventDefault();
    inputId = $(this).data("ref");
    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
});

</script>
@endpush
