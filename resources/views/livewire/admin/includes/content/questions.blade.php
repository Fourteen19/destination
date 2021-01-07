<div id="questions" class="tab-pane @if ($activeTab == "questions") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            @foreach($relatedQuestions as $key => $relatedQuestion)

                <div class="form-group" wire:key="related-question-{{$relatedQuestion['key_id']}}">

                    <div wire:ignore>
                        <span>Question {{ $key }}</span>
                        {!! Form::textarea('relatedQuestions['.$key.'][title]', '', array('placeholder' => 'Question','class' => 'form-control tiny_question_title', 'wire:model.lazy' => 'relatedQuestions.'.$key.'.title', 'id' => 'relatedQuestions['.$key.'][title]' )) !!}
                        @error('relatedQuestions.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>


                    {{--
        <div wire:ignore>
        <textarea class="tiny"
                id='relatedQuestions[{{$key}}][title]'
                name='relatedQuestions[{{$key}}][title]'
                rows="20"
                wire:model = "relatedQuestions.{{$key}}.title"
                wire:key="relatedQuestions.{{$key}}.title"
                x-data
                x-ref="relatedQuestions.{{$key}}.title"
                x-init="
                tinymce.init({
                                selector: '.tiny',
                                setup: function(editor) {
                                    editor.on('init change', function () {
                                        editor.save();
                                    });
                                    editor.on('blur', function(e) {

                                        myStr = tinymce.activeEditor.id;
                                        id = myStr.match(/\d+/);
                                        @this.set('relatedQuestions.'+id+'.title', tinymce.get('relatedQuestions['+id+'][title]').getContent());
                                    });
                                }
                            });
                ">
            </textarea>
        </div>
--}}
                    <br/>
                    <span>Answer {{ $key }}</span>
                    <input type="textarea" class="form-control tiny_question_answer" placeholder="Enter text"  name="relatedQuestions[{{$key}}]['text']" wire:model.lazy="relatedQuestions.{{$key}}.text">
                    @error('relatedQuestions.'.$key.'.text')<span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedQuestion({{ $key }});">remove question {{ $key }}</button>

            @endforeach

            <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedQuestion();">Add a question</button>

        </div>
    </div>
</div>
