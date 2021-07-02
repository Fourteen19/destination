<div id="vacancy-image" class="tab-pane px-0 @if ($activeTab == "vacancy-image") active @else fade @endif" wire:key="vacancy-image-pane">
<div class="row">
        <div class="col-lg-8">
            <div class="p-4">
            <p class="fw700">Vacancy images are required to be 1000px x 800px exactly.</p>
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
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('vacancy_image', 'Vacancy Image'); !!}
                @error('vacancyImage') <span class="text-danger error">{{ $message }}</span>@enderror
                <div class="input-group">
                {!! Form::text('vacancy_image', null, array('placeholder' => 'Vacancy Image','class' => 'form-control', 'maxlength' => 255, 'id' => "vacancy_image", 'wire:model' => 'vacancyImage' )) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-vacancy-image">Select</button>
                </div>
                </div>
                <div class="article-image-preview">
                    <img src="{{ $vacancyImageOriginal }}">
                </div>
            </div>

        </div>
    </div>
</div>
