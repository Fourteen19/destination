<div id="downloads" class="tab-pane px-0 @if ($activeTab == "downloads") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">
        <div class="rounded p-4 form-outer">
        @foreach($relatedDownloads as $key => $relatedDownload)
            <div class="form-row">
                <div class="form-group col-6 mb-3">
                    <label>Enter the download title</label>
                    <input type="text" class="form-control" placeholder="Enter title"  name="relatedDownloads[{{$key}}]['title']" wire:model.lazy="relatedDownloads.{{$key}}.title">
                    @error('relatedDownloads.'.$key.'.title')<div class="text-danger error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-6 mb-3">
                    <label>Select the file</label>
                    <input type="text" class="form-control" placeholder="Enter URL"  name="relatedDownloads[{{$key}}]['url']" wire:model.lazy="relatedDownloads.{{$key}}.url">
                    @error('relatedDownloads.'.$key.'.url')<div class="text-danger error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="col">
                <button class="btn btn-danger" wire:click.prevent="removeRelatedDownload({{$key}})"><i class="fas fa-trash-alt mr-2"></i>Remove this download</button>
                </div>
            </div>
            <div class="form-split"></div>
        

        @endforeach
        <button class="mydir-action btn" wire:click.prevent="addRelatedDownload()"><i class="fas fa-plus-square mr-2"></i>Add a download</button>

        </div>
        </div>
    </div>
</div>
