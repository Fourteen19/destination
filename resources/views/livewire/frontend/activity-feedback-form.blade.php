<div>

    @if (count($questionsList) > 0)

        @foreach ($questionsList as $key => $value)

            <div class="form-group">
                @error('question_'.$key) <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('question_'.$value['question_id'], $value['text'] ); !!}
                {!! Form::textarea('question_'.$value['question_id'], $value['text'], array('placeholder' => 'Question '.$value['question_id'] ,'class' => 'form-control', 'maxlength' => 999, 'wire:model.defer' => 'question_'.$value['question_id'])) !!}
            </div>

        @endforeach

    @endif
</div>
