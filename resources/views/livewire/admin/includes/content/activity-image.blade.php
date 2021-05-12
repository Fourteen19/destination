<div id="activity-image" class="tab-pane px-0 @if ($activeTab == "activity-image") active @else fade @endif" wire:key="activity-image-pane">
    <div class="row">
        <div class="col-xl-8">
        <div class="rounded p-4 form-outer">
        <div class="form-group">
            @error('banner') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('banner', 'Activity Image'); !!}
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

        <div class="form-group">
            {!! Form::label('banner_alt', 'Alt Tag'); !!}
            {!! Form::text('banner_alt', null, array('placeholder' => 'Alt Tag','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'banner_alt')) !!}
            @error('banner_alt') <div class="text-danger error">{{ $message }}</div>@enderror
        </div>

        </div>
        </div>
    </div>
</div>
