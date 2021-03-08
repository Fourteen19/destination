<div id="images" class="tab-pane px-0 @if ($activeTab == "images") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">
        <div class="rounded p-4 form-outer">
        @foreach($relatedImages as $key => $relatedImage)
            <div class="form-row">
                <div class="form-group col-6 mb-3">
                    <label>Enter the image caption</label>
                    <input type="text" class="form-control" placeholder="Enter caption"  name="relatedImages[{{$key}}]['title']" wire:model.defer="relatedImages.{{$key}}.title">
                    @error('relatedImages.'.$key.'.title')<div class="text-danger error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-6 mb-3">
                    <label>Select an image</label>
                    <input type="text" class="form-control" placeholder="Select an image" id="file_relatedImages[{{$key}}]['url']" name="relatedImages[{{$key}}]['url']" wire:model.lazy="relatedImages.{{$key}}.url"  readonly>
                    @error('relatedImages.'.$key.'.url')<div class="text-danger error">{{ $message }}</div>@enderror
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary add-image" data-ref="file_relatedImages[{{$key}}]['url']" id="relatedImages_{{$key}}_url" type="button">Select</button>
                    </div>
                    @if (!empty($relatedImages[$key]['open_link']))
                        <img src="{{ $relatedImages[$key]['open_link'] }}">
                    @endif
                </div>

                @push('scripts')
                <script>
                    {{-- adds listener for loaded images --}}
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("relatedImages_{{$key}}_url").addEventListener('click', (event) => {
                            event.preventDefault();
                            inputId = "file_relatedImages[{{$key}}]['url']";
                            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                        });
                    });

                </script>
                @endpush

            </div>
            <div class="form-row mb-4">
                <div class="col">
                <button class="btn btn-danger" wire:click.prevent="removeRelatedImage({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt mr-2"></i>Remove this image</button>
                </div>
            </div>
            <div class="form-split"></div>


        @endforeach
        <button class="mydir-action btn" wire:click.prevent="addRelatedImage()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add a image</button>

        </div>
        </div>
    </div>
</div>


@push('scripts')
<script>

{{-- adds dynamic listener for added images --}}
$(document).on('click', '.add-image', function() {
    event.preventDefault();
    inputId = $(this).data("ref");
    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
});

</script>
@endpush
