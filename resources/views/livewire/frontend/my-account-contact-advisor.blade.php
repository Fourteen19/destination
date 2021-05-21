<div class="row">
    <div class="col-lg-6">

        @if ($success == 0)

            <form class="pb-5" wire:submit.prevent="submit">

                <div class="form-group"  wire:ignore>
                    {!! Form::label('Whatsyourquestion', 'What\'s your question about?'); !!}
                    <select class="form-control form-control-lg" id="questionType" name="questionType" wire:model.defer="questionType">
                        @foreach($questionTypeList as $key => $questionType)
                            <option value="{{ $questionType }}">{{ $questionType }}</option>
                        @endforeach
                    </select>
                    @error('questionType') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="Yourquestion">Your question</label>
                    <textarea class="form-control form-control-lg" id="Yourquestion" rows="6" wire:model.defer="questionText"></textarea>
                    @error('questionText') <span class="error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled"class="platform-button border-0 t-def mt-5">
                    Send your message
                </button>

                {{ $formMessage }}

            </form>

        @endif

        {{ $formMessage }}

    </div>
</div>
