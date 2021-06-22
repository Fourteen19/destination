<div id="activity-image" class="tab-pane px-0 @if ($activeTab == "activity-image") active @else fade @endif" wire:key="activity-image-pane">
    <div class="row">
        <div class="col-lg-8">
            <div class="p-4">
            <p class="fw700">Activity images are required to be 1194px x 800px exactly.</p>
            <p>Optimum setings for your images:</p>
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
