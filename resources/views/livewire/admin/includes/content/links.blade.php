<div id="links" class="tab-pane @if ($activeTab == "links") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            @foreach($relatedLinks as $key => $relatedLink)

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter title"  name="relatedLinks[{{$key}}]['title']" wire:model.lazy="relatedLinks.{{$key}}.title">
                            @error('relatedLinks.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror

                            <input type="text" class="form-control" placeholder="Enter URL"  name="relatedLinks[{{$key}}]['url']" wire:model.lazy="relatedLinks.{{$key}}.url">
                            @error('relatedLinks.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedLink({{$key}})">remove</button>

            @endforeach

            <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedLink({{$relatedLinksIteration}})">Add a link</button>

        </div>
    </div>
</div>
