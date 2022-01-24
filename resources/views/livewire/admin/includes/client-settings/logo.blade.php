<div id="logo" class="tab-pane @if ($activeTab == "logo") active @else fade @endif"  wire:key="logo-pane">
    <div class="row">
        <div class="col-lg-8">
            <div class="p-4">
            <p class="fw700">System logo image information</p>
            <p>Optimum setings for your images:</p>
            <ul class="small">
                <li>Names in lowercase</li>
                <li>No spaces in your file name (replace with '_' or '-')</li>
                <li>Transparent PNGs work best</li>
                <li>For optimum results used a graphic with the width to height ratio between 4:1 and 3:2 in landscape.</li>
                <li>SVG format is not supported in this instance</li>
                <li>Files should be compressed. Optimum file size range is between 50 - 150k. Maximum is 300k in exceptional cases.</li>
            </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="rounded p-4 form-outer">
                <div class="form-group">
                    @error('logo') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('logo', 'System logo'); !!}
                    <div class="input-group">
                    {!! Form::text('logo', null, array('placeholder' => 'System logo','class' => 'form-control', 'maxlength' => 255, 'id' => "logo_image", 'wire:model' => 'logo' )) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image-logo">Select</button>
                    </div>
                    </div>
                    <div class="article-image-preview">
                        <img src="{{ $logoOriginal }}">
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('logo_alt', 'Alt Tag'); !!}
                    {!! Form::text('logo_alt', null, array('placeholder' => 'Alt Tag','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'logo_alt')) !!}
                    @error('logo_alt') <div class="text-danger error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

</div>
