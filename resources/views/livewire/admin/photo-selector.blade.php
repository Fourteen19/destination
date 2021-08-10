<div class="w-100">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h2 class="border-bottom pb-2 mb-4"><i class="fas fa-portrait mr-2"></i>Admin User (Adviser) Image</h2>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="p-4">
            <p class="fw700">Photo images are required to be 300px x 300px minimum. Your image will be centrally cropped - see the preview below.</p>
            <p>Optimum setings for your images:</p>
            <ul class="small">
                <li>Names in lowercase</li>
                <li>No spaces in your file name (replace with '_' or '-')</li>
                <li>Photographs should be saved as JPG</li>
                <li>Indexed graphics such as logos, diagrams etc should be saved as PNG or GIF</li>
                <li>SVG format is not supported in this instance</li>
                <li>Files should be compressed. Optimum file size range is between 50 - 100k. Maximum is 100k in exceptional cases.</li>
            </ul>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="rounded p-4 form-outer">
            <div class="form-group">
                @error('photo') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('photo', 'Photo'); !!}
                <div class="input-group">
                {!! Form::text('photo', null, array('placeholder' => 'Photo','class' => 'form-control', 'maxlength' => 255, 'id' => "photo", 'wire:model' => 'photo' )) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-image-photo">Select</button>
                </div>
                </div>
                <label class="mt-4 mb-0">Original Image:</label>
                <div class="article-image-preview">
                    <img src="{{ $photoOriginal ?? ''}}">
                </div>

                <label class="mt-4 mb-0">Cropped & Resized Preview:</label>
                <div class="article-image-preview">
                    <img src="{{ $photoPreview }}" class="rounded-circle">
                </div>
            </div>

        </div>
    </div>

</div>


@push('scripts')
<script>

    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image-photo').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'photo_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        if (inputId == 'photo_image'){
            livewire.emit('make_photo_image', $url);
        }

    }

</script>
@endpush
