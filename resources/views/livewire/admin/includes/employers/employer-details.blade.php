<div id="employer-details" class="tab-pane px-0 @if ($activeTab == "employer-details") active @else fade @endif" wire:key="employer-details-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('name', 'Name'); !!}
                @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('name', $this->name, array('placeholder' => 'Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'name' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('website', 'Web site'); !!}
                {!! Form::text('website', $this->website, array('placeholder' => 'Web site','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'website' )) !!}
            </div>

            <div class="form-group">
                @error('logo') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('logo', 'Employer Logo'); !!}
                <div class="input-group">
                {!! Form::text('logo', null, array('placeholder' => 'Employer Logo','class' => 'form-control', 'maxlength' => 255, 'id' => "employer_logo", 'wire:model' => 'logo' )) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-employer-logo">Select</button>
                </div>
                </div>
                <div class="article-image-preview">
                    <img src="{{ $employerLogoOriginal }}">
                </div>
            </div>

        </div>
    </div>
</div>
