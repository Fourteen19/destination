<div id="videos" class="tab-pane px-0 @if ($activeTab == "videos") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

        <div class="rounded p-4 form-outer">
            <ul wire:sortable="updateVideoOrder" class="drag-list">
            @foreach($relatedVideos as $key => $video)
                <li wire:sortable.item="{{ $key }}" wire:key="{{ $key }}" class="drag-box">
                    <div class="row">
                        <div class="col-md-1"><div wire:sortable.handle class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <label class="mr-2">Video URL:</label>
                                <input type="text" class="form-control" placeholder="Enter video URL"  name="relatedVideos[{{$key}}]['url']" wire:model.lazy="relatedVideos.{{$key}}.url">
                                @error('relatedVideos.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-1 ml-auto">
                            <button class="btn btn-danger" wire:click.prevent="removeRelatedVideo({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>

                </li>
            @endforeach
            </ul>
            <button class="mydir-action btn" wire:click.prevent="addRelatedVideo({{$relatedVideosIteration}})" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a video</button>
        </div>

        </div>
    </div>
</div>
