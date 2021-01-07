<div id="videos" class="tab-pane @if ($activeTab == "videos") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

        <div>
            <ul wire:sortable="updateVideoOrder">
            @foreach($relatedVideos as $key => $video)
                <li wire:sortable.item="{{ $key }}" wire:key="{{ $key }}">
                    <h4 wire:sortable.handle>Handle</h4>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter video URL"  name="relatedVideos[{{$key}}]['url']" wire:model.lazy="relatedVideos.{{$key}}.url">
                                @error('relatedVideos.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedVideo({{$key}})">remove</button>
                        </div>
                    </div>

                </li>
            @endforeach
            </ul>
            <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedVideo({{$relatedVideosIteration}})">Add a video</button>
        </div>

        </div>
    </div>
</div>
