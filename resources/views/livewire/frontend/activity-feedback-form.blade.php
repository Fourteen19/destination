@if (count($questionsList) > 0)
    <section class="bg-2 rounded-lg my-5 t-w py-5">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <h4 class="t24 fw700 mb-4 t-w text-center">Answer these questions to complete your activity</h4>
                <form wire:submit.prevent="submit">
                @foreach ($questionsList as $key => $value)

                <div class="form-row">
                    <div class="col-xl-1"><div class="act-num text-center">{{$loop->iteration}}).</div></div>
                    <div class="form-group col-xl-10 mt-1">
                        @error('question_'.$key) <span class="text-danger error">{{ $message }}</span>@enderror
                        {!! Form::label('question_'.$value['question_id'], $value['text'], array('class' => 't20')); !!}
                        {!! Form::textarea('question_'.$value['question_id'], $value['text'], array('placeholder' => 'Question '.$value['question_id'] ,'class' => 'form-control', 'maxlength' => 999, 'wire:model.defer' => 'question'.$value['question_id'])) !!}
                    </div>

                </div>

                @endforeach

                <div class="text-center"><button type="submit" wire:loading.attr="disabled" class="platform-button border-0 t-w t20 mt-3">Save my answers</button></div>

                {{ $updateMessage }}

                </form>
            </div>
        </div>
    </section>
@endif
