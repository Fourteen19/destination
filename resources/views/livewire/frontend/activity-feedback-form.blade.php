@if (count($questionsList) > 0)
<section class="bg-2 rounded-lg my-5 t-w py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="p-3 p-xl-0">
                <h4 class="t24 fw700 mb-4 t-w text-lg-center">Answer these questions to complete your activity</h4>
                <form wire:submit.prevent="submit">
                    @csrf
                    @foreach ($questionsList as $key => $value)

                    <div class="form-row">
                        <div class="col-lg-1">
                            <div class="act-num text-lg-center">{{$loop->iteration}}).</div>
                        </div>
                        <div class="form-group col-xl-10 col-lg-11 mt-1">
                            @error('question_'.$key) <span class="text-danger error">{{ $message }}</span>@enderror
                            {!! Form::label('question_'.$value['question_id'], $value['text'], array('class' => 't20'));
                            !!}
                            {!! Form::textarea('question_'.$value['question_id'], $value['answer'], array('placeholder'
                            => 'Enter your answer' ,'class' => 'form-control activity-answer', 'maxlength' => 999,
                            'wire:model.defer' => 'question'.$value['question_id'])) !!}
                        </div>

                    </div>

                    @endforeach

                    <div class="text-lg-center"><button type="submit" wire:loading.attr="disabled"
                            class="platform-button border-0 t-w t20 mt-3">Save my answers</button></div>

                    @if ($updateMessage)
                    <div class="row mt-4">
                        <div class="col-12 text-lg-center">
                            <span class="fw700 t24 d-flex align-items-center justify-content-center">{!! $updateMessage
                                !!}</span>
                        </div>
                    </div>
                    @endif


                </form>
            </div>
        </div>
    </div>
</section>
@endif
