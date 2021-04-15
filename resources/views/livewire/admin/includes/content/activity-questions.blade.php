<div id="activity-questions" class="tab-pane px-0 @if ($activeTab == "activity-questions") active @else fade @endif" wire:key="activity-questions-pane">
    <div class="row">
        <div class="col-lg-8">
            <div class="rounded p-4 form-outer">

                @foreach($relatedActivityQuestions as $key => $relatedActivityQuestion)

                    <div class="form-group">
                        {!! Form::label("relatedActivityQuestions[".$key."][text]", "Question ".($key+1)); !!}
                        {!! Form::textarea('relatedActivityQuestions['.$key.'][text]', '', array('placeholder' => 'Question','class' => 'form-control', 'wire:model.defer' => 'relatedActivityQuestions.'.$key.'.text', 'id' => 'relatedActivityQuestions['.$key.'][text]' )) !!}
                        @error('relatedActivityQuestions.'.$key.'.text')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>

                @endforeach

            </div>

        </div>
    </div>
</div>
