<div id="activity-questions" class="tab-pane px-0 @if ($activeTab == "activity-questions") active @else fade @endif" wire:key="activity-questions-pane">
    <div class="row">
        <div class="col-lg-8">
            <div class="rounded p-4 form-outer">

                @foreach($relatedActivityQuestions as $key => $relatedActivityQuestion)

                    <div class="form-group">
                        {!! Form::label("relatedActivityQuestions[".$key."][title]", "Question ".($key+1)); !!}
                        {!! Form::textarea('relatedActivityQuestions['.$key.'][title]', '', array('placeholder' => 'Question','class' => 'form-control tiny_question_title', 'wire:model.defer' => 'relatedActivityQuestions.'.$key.'.title', 'id' => 'relatedActivityQuestions['.$key.'][title]' )) !!}
                        @error('relatedActivityQuestions.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>

                @endforeach

            </div>

        </div>
    </div>
</div>
