<div id="downloads" class="tab-pane @if ($activeTab == "downloads") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

        @foreach($relatedDownloads as $key => $relatedDownload)

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter title"  name="relatedDownloads[{{$key}}]['title']" wire:model.lazy="relatedDownloads.{{$key}}.title">
                @error('relatedDownloads.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror

                <input type="text" class="form-control" placeholder="Enter URL"  name="relatedDownloads[{{$key}}]['url']" wire:model.lazy="relatedDownloads.{{$key}}.url">
                @error('relatedDownloads.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
            </div>

            <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedDownload({{$key}})">remove</button>

        @endforeach
        <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedDownload()">Add a download</button>

        </div>
    </div>
</div>
