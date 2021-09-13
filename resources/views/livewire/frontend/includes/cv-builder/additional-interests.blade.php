<div id="additional-interests" class="tab-pane @if ($activeTab == "additional-interests") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

            <div class="px-lg-4">
                <div class="mb-5">{{ $staticContent['cv_additional_interests_instructions'] }}</div>

                <div class="form-group row mb-3">
                    <div class="col-lg-2">{!! Form::label('additional_interests', 'Additional Interests'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::textarea('additional_interests', $this->additional_interests, array('placeholder' => 'Additional Interests', 'class' => 'form-control form-control-lg', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'additional_interests')) !!}
                    @error('additional_interests') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a class="examples-link" data-toggle="collapse" href="#ai-example" role="button" aria-expanded="false" aria-controls="ai-example">For some inspiration, advice and ideas for your additional interests - Click here to see some examples.</a>

                        <div class="collapse" id="ai-example">
                            <div class="example-text">
                            {!! $staticContent['cv_additional_interests_example'] !!}
                            </div>
                        </div>
                    </div>
                </div>

            
            </div>
        </div>
    </div>

    <div class="row justify-content-between mt-5">
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('education')" wire:loading.attr="disabled" class="btn platform-button"><i class="fas fa-caret-left mr-2"></i>Previous</button>
        </div>
        <div class="col-auto">
            <button type="button" wire:click.prevent="updateTab('references')" wire:loading.attr="disabled" class="btn platform-button">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>

</div>
