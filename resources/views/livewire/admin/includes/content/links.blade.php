<div id="links" class="tab-pane px-0 @if ($activeTab == "links") active @else fade @endif" wire:key="links-pane">
    <div class="row">
        <div class="col-lg-8">

            <div wire:sortable="updateGroupOrder" wire:sortable-group="updateLinksOrder" style="display: flex">
                <div wire:key="group-links" wire:sortable.item="links">

                    <div class="rounded p-4 form-outer">
                        <ul wire:sortable-group.item-group="links">
                            {{-- <ul wire:sortable="updateLinksOrder" id="links-list" wire:key="links-list" class="drag-list"> --}}
                            @foreach($relatedLinks as $key => $relatedLink)
                                {{-- <li wire:sortable.item="{{ $key }}" wire:key="link-{{ $key }}" class="drag-box"> --}}
                                <li wire:sortable-group.item="{{ $key }}" wire:key="link-{{ $key }}" class="drag-box">
                                    <div class="row">
                                    <div class="col-md-1"><div wire:sortable.handle class="drag-handle"><i class="fas fa-arrows-alt"></i></div></div>
                                        <div class="form-row">
                                            <div class="form-group col-6 mb-3">
                                                <label>Enter the link title</label>
                                                <input type="text" class="form-control" placeholder="Enter link title"  name="relatedLinks[{{$key}}]['title']" wire:model.lazy="relatedLinks.{{$key}}.title">
                                                @error('relatedLinks.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group col-6 mb-3">
                                                <label>Enter the link URL</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3">https://</span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Enter URL"  name="relatedLinks[{{$key}}]['url']" wire:model.lazy="relatedLinks.{{$key}}.url">
                                                </div>
                                                @error('relatedLinks.'.$key.'.url')<div class="text-danger error">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="col">
                                            <button class="btn btn-danger" wire:click.prevent="removeRelatedLink({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt mr-2"></i>Remove this link</button>
                                            </div>
                                        </div>
                                        <div class="form-split"></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <button class="mydir-action btn" wire:click.prevent="addRelatedLink()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a link</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
