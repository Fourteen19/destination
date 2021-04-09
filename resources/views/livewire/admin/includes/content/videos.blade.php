<div id="videos" class="tab-pane px-0 @if ($activeTab == "videos") active @else fade @endif" wire:key="videos-pane">
    <div class="row">
        <div class="col-lg-8">
            <div class="p-4">
            <h4>Instructions for adding a video from YouTube</h4>
            <ul>
                <li>On the video path within Youtube, click on the "Share" option below the video.</li>
                <li>Within the share options that are presented, select "Embed"</li>
                <li>The window will show your video to the left and some embed code to the right. Within the embed code locate the 'src' element.</li>
                <li>Copy the URL between the quotation marks. It should look something like this: https://www.youtube.com/embed/HSsqzzuGTPo</li>
                <li>Click the "Add Video" button below and paste the URL you copied from Youtube into the form below.</li>
                <li>To preview you video - click on the "Content Preview" tab.</li>
            </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">

            <div class="rounded p-4 form-outer">
                <ul id="sortable-videos" class="drag-list">
                @foreach($relatedVideos as $key => $video)
                    <li id="{{$key}}" class="drag-box" wire:key="video-{{ $key }}">
                        <div class="row">
                            <div class="col-md-1"><div class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                            <div class="col-md-6">
                                <div class="form-inline">
                                    <label class="mr-2">Video URL:</label>
                                    <input type="text" class="form-control drag-input" placeholder="Enter video URL"  name="relatedVideos[{{$key}}]['url']" wire:model.lazy="relatedVideos.{{$key}}.url">
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
                <button class="mydir-action btn" wire:click.prevent="addRelatedVideo()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a video</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>

    $( function() {
        var sortedIDs = $( "#sortable-videos" ).sortable({
            update: function(event, ui) {
                var videoOrder = $(this).sortable('toArray').toString();
                Livewire.emit('update_videos_order', videoOrder)
            }
        });

        $( "#sortable-videos" ).disableSelection();

    } );
  </script>
@endpush
