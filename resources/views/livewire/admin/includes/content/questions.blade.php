<div id="questions" class="tab-pane @if ($activeTab == "questions") active @else fade @endif" wire:key="questions-pane">
    <div class="row">
        <div class="col-lg-6">

            @foreach($relatedQuestions as $key => $relatedQuestion)

                <div @if ($relatedQuestion['deleted'] == True) style="display:none" @endif >

                    <div wire:ignore class="form-group" wire:key="related-question-{{$relatedQuestion['key_id']}}">
                        <div class="mb-4">
                            <label>Question / Statement</label>
                            {!! Form::textarea('relatedQuestions['.$key.'][title]', '', array('placeholder' => 'Question / Statment','class' => 'form-control', 'wire:model.defer' => 'relatedQuestions.'.$key.'.title', 'id' => 'relatedQuestions['.$key.'][title]' )) !!}
                            @error('relatedQuestions.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label>Answer</label>
                            {!! Form::textarea('relatedQuestions['.$key.'][text]', '', array('placeholder' => 'Question','class' => 'form-control tiny_question_text', 'wire:model.defer' => 'relatedQuestions.'.$key.'.text', 'id' => 'relatedQuestions['.$key.'][text]' )) !!}
                            @error('relatedQuestions.'.$key.'.text')<span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedQuestion({{ $key }});">Remove Question</button>
                    <br><br><br>

                </div>

            @endforeach

            <button class="mydir-action btn" wire:click.prevent="addRelatedQuestion();"><i class="fas fa-plus-square mr-2"></i>Add a question</button>

        </div>
    </div>
</div>
