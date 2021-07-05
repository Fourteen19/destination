<div id="employer-details" class="tab-pane px-0 @if ($activeTab == "employer-details") active @else fade @endif" wire:key="employer-details-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('name', 'Employer Name'); !!}
                @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('name', $this->name, array('placeholder' => 'Employer Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'name' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('website', 'Employer Web site'); !!}
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text">https://</div>
                    </div>
                    {!! Form::text('website', $this->website, array('placeholder' => 'Employer Web site','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'website' )) !!}
                </div>
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

            <div class="form-group">
                {!! Form::label('employerLogo_alt', 'Alt Tag'); !!}
                {!! Form::text('employerLogo_alt', null, array('placeholder' => 'Alt Tag','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'employerLogo_alt')) !!}
                @error('employerLogo_alt') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="rounded p-4 pr-5 form-outer">
                <div class="form-group">
                    @livewire('admin.employer-article-selector', ['label' => 'Select the Employer article that you suggest the user should read about this employer (optional)', 'articleUuid' => $employer_article, 'name' => 'employer_article', 'includeClientArticles' => True, 'key' => "employer_article"])
                    <small>(Note: The read next preview will not show in the content preview)</small>
                </div>
            </div>

        </div>
    </div>
</div>
