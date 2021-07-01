<div id="vacancy-image" class="tab-pane px-0 @if ($activeTab == "vacancy-image") active @else fade @endif" wire:key="vacancy-image-pane">
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
