<div id="personal-profile" class="tab-pane @if ($activeTab == "personal-profile") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

            <div class="px-lg-4">
                <div class="mb-5">{{ $staticContent['cv_personal_profile_instructions'] }}</div>

                <div class="form-group row mb-3">
                    <div class="col-lg-2"> {!! Form::label('personal_profile', 'Personal Profile'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::textarea('personal_profile', $this->personal_profile, array('placeholder' => 'Personal Profile', 'class' => 'form-control  form-control-lg', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'personal_profile')) !!}
                    @error('personal_profile') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a class="examples-link" data-toggle="collapse" href="#pp-example" role="button" aria-expanded="false" aria-controls="pp-example">For some inspiration, advice and ideas for your personal profile - Click here to see some examples.</a>

                        <div class="collapse" id="pp-example">
                            <div class="example-text">
                            {!! $staticContent['cv_personal_profile_example'] !!}
                            </div>
                        </div>
                    </div>
                </div>
  
 



            
            </div>
        </div>
    </div>

    <div class="row justify-content-between mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('personal-details')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('employment')" wire:loading.attr="disabled" class="btn platform-button">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>

</div>