<div id="questions" class="tab-pane @if ($activeTab == "questions") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">



            @foreach($relatedQuestions as $key => $relatedQuestion)

                <div class="form-group" wire:key="related-question-{{$relatedQuestion['key_id']}}">

                    <div>
                        <span>Question {{ $key }}</span>
            {{--            {!! Form::textarea('relatedQuestions['.$key.'][title]', '', array('placeholder' => 'Question','class' => 'form-control tiny_question_title', 'wire:model.lazy' => 'relatedQuestions.'.$key.'.title', 'id' => 'relatedQuestions['.$key.'][title]' )) !!}
            --}}

                            <textarea class="tiny" placeholder="Type anything you want..." id="relatedQuestions[{{$key}}][title]" name="relatedQuestions[{{$key}}][title]" aria-hidden="true" wire:model.lazy='relatedQuestions.{{$key}}.title'>ABC</textarea>

                            {{-- <x-input.tinymce wire:model.lazy="relatedQuestions.{{$key}}.title" placeholder="Type anything you want..." id="relatedQuestions[{{$key}}][title]"  name="relatedQuestions[{{$key}}][title]"/> --}}
                            @error('relatedQuestions.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>

                    <br/>
                    <span>Answer {{ $key }}</span>
                    <input type="textarea" class="form-control tiny_question_answer" placeholder="Enter text"  name="relatedQuestions[{{$key}}]['text']" wire:model.lazy="relatedQuestions.{{$key}}.text">
                    @error('relatedQuestions.'.$key.'.text')<span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedQuestion({{ $key }});">remove question {{ $key }}</button>
                <br><br><br>
                <div>--------------------------------------------------------------------------------------------------------------------------------</div>
                <br><br><br>
            @endforeach

            <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedQuestion();">Add a question</button>

        </div>
    </div>
</div>
