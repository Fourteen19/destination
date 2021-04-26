<div>

    @if (count($questionsList) > 0)

        <form wire:submit.prevent="submit">

            @foreach ($questionsList as $key => $value)

                <div class="form-group">
                    @error('question_'.$key) <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('question_'.$value['question_id'], $value['text'] ); !!}
                    {!! Form::textarea('question_'.$value['question_id'], $value['answer'], array('placeholder' => 'Question '.$value['question_id'] ,'class' => 'form-control', 'maxlength' => 999, 'wire:model.defer' => 'question'.$value['question_id'] )) !!}
                </div>

            @endforeach


            <button type="button" wire:click.prevent="submit()" wire:loading.attr="disabled" class="btn mydir-button mr-2">Save</button>

        </form>

    @endif

</div>
