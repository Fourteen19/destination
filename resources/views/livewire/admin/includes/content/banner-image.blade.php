<div id="banner-image" class="tab-pane px-0 @if ($activeTab == "banner-image") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">
        <div class="rounded p-4 form-outer">
        <div class="form-group">
            @error('bannerOriginal') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('banner', 'Banner Image'); !!}
            <div class="input-group">
            {!! Form::text('banner', null, array('placeholder' => 'Banner Image','class' => 'form-control', 'maxlength' => 255, 'id' => "banner_image", 'wire:model' => 'banner' )) !!}
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-image-banner">Select</button>
            </div>
            </div>
            <div class="article-image-preview">
                <img src="{{ $bannerOriginal }}">
            </div>
        </div>
        </div>
        </div>
    </div>
</div>
