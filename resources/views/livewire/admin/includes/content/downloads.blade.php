<div id="downloads" class="tab-pane px-0 @if ($activeTab == "downloads") active @else fade @endif" wire:key="downloads-pane">
    <div class="row">
        <div class="col-lg-8">
        <div class="rounded p-4 form-outer">
            <ul wire:sortable="updateDownloadsOrder" class="drag-list">
            @foreach($relatedDownloads as $key => $relatedDownload)
                <li wire:sortable.item="{{ $key }}" wire:key="download_{{ $key }}" class="drag-box">
                    <div class="row">
                        <div class="col-md-1"><div wire:sortable.handle class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                        <div class="form-row">
                            <div class="form-group col-6 mb-3">
                                <label>Enter the download title</label>
                                <input type="text" class="form-control" placeholder="Enter title"  name="relatedDownloads[{{$key}}]['title']" wire:model.defer="relatedDownloads.{{$key}}.title">
                                @error('relatedDownloads.'.$key.'.title')<div class="text-danger error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6 mb-3">
                                <label>Select the file</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter URL" id="file_relatedDownloads[{{$key}}]['url']" name="relatedDownloads[{{$key}}]['url']" wire:model.lazy="relatedDownloads.{{$key}}.url" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" data-ref="file_relatedDownloads[{{$key}}]['url']" id="relatedDownloads_{{$key}}_url" type="button">Select</button>
                                    </div>
                                </div>
                                {{--
                                @error('relatedDownloads.'.$key.'.url')<div class="text-danger error">{{ $message }}</div>@enderror
                                @if (!empty($relatedDownloads[$key]['open_link']))
                                    <a href="{{ $relatedDownloads[$key]['open_link'] }}" target="_blank">open</a>
                                @endif --}}
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

                        </div>
                        <div class="form-row mb-4">
                            <div class="col">
                            <button class="btn btn-danger" wire:click.prevent="removeRelatedDownload({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt mr-2"></i>Remove this download</button>
                            </div>
                        </div>
                        <div class="form-split"></div>
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

{{-- adds dynamic listener for added downloads --}}
$(document).on('click', '.add-download', function() {
    //console.log($(this).data("ref"));
    event.preventDefault();
    inputId = $(this).data("ref");
    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
});

</script>
@endpush
