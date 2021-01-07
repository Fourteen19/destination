<div id="banner-image" class="tab-pane @if ($activeTab == "banner-image") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

        <div class="form-group">
            @error('bannerOriginal') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('banner', 'Banner Image'); !!}
            {!! Form::text('banner', null, array('placeholder' => 'Banner Image','class' => 'form-control', 'maxlength' => 255, 'id' => "banner_image", 'wire:model' => 'banner' )) !!}
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-image-banner">Select</button>
            </div>
            <div>
                <img src="{{ $bannerOriginal }}">
            </div>
        </div>

        </div>
    </div>
</div>
