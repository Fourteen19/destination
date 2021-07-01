<div id="images" class="tab-pane px-0 @if ($activeTab == "images") active @else fade @endif" wire:key="images-pane">
    <div class="row">
        <div class="col-lg-8">
            <div class="p-4">
            <p class="fw700">Optimum setings for your images:</p>
            <ul class="small">
                <li>Names in lowercase</li>
                <li>No spaces in your file name (replace with '_' or '-')</li>
                <li>Photographs should be saved as JPG</li>
                <li>Indexed graphics such as logos, diagrams etc should be saved as PNG or GIF</li>
                <li>SVG format is not supported in this instance</li>
                <li>Files should be compressed. Optimum file size range is between 50 - 150k. Maximum is 300k in exceptional cases.</li>
            </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
        <div class="rounded p-4 form-outer">
        @foreach($relatedImages as $key => $relatedImage)
            <div class="form-row">
                <div class="form-group col-12 mb-3">
                    <label>Select an image</label>
                    <div class="input-group">
                    <input type="text" class="form-control" placeholder="Select an image" id="file_relatedImages[{{$key}}]['url']" name="relatedImages[{{$key}}]['url']" wire:model.defer="relatedImages.{{$key}}.url" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary add-image" data-ref="file_relatedImages[{{$key}}]['url']" id="relatedImages_{{$key}}_url" type="button">Select</button>
                    </div>
                    </div>
                    @error('relatedImages.'.$key.'.url')<div class="text-danger error">{{ $message }}</div>@enderror
                    @if (!empty($relatedImages[$key]['open_link']))
                        <div class="my-4"><img src="{{ $relatedImages[$key]['open_link'] }}" class="img-fluid"></div>
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
            <div class="form-row">
                <div class="form-group col-12 mb-3">
                    <label>Enter the image caption</label>
                    <textarea class="form-control" rows="4" cols="50" placeholder="Enter caption"  name="relatedImages[{{$key}}]['title']" wire:model.defer="relatedImages.{{$key}}.title"></textarea>
                    @error('relatedImages.'.$key.'.title')<div class="text-danger error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12 mb-3">
                    <label>Enter the image ALT tag</label>
                    <input type="text" class="form-control" placeholder="Enter the ALT tag" id="file_relatedImages[{{$key}}]['alt']" name="relatedImages[{{$key}}]['alt']" wire:model.defer="relatedImages.{{$key}}.alt"></textarea>
                    @error('relatedImages.'.$key.'.alt')<div class="text-danger error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="col">
                <button class="btn btn-danger" wire:click.prevent="removeRelatedImage({{$key}})" wire:loading.attr="disabled"><i class="fas fa-trash-alt mr-2"></i>Remove this image</button>
                </div>
            </div>
            <div class="form-split"></div>


        @endforeach
        <button class="mydir-action btn" wire:click.prevent="addRelatedImage()" wire:loading.attr="disabled"><i class="fas fa-plus-square mr-2"></i>Add an image</button>

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