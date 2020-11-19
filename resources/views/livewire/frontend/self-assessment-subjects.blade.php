<div>
    <form wire:submit.prevent="submit">

        @error('subjects') <span class="error">{{ $message }}</span> @enderror

        @foreach($subjects as $subject)
            <label><input type="checkbox" name="subjects[]" wire:click="AddSelectedSubjects({{$subject->id}})" id="subject_{{$subject->id}}" value="{{$subject->id}}" /> {{$subject->name}}</label>
        @endforeach

        <button type="submit">Next</button>

    </form>
</div>
