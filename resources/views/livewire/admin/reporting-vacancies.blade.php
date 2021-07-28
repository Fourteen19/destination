<div>

    <div class="form-group mb-4">
        <label for="institution">Filter by Institution</label>
        <select class="form-control" id="institution" name="institution" wire:model.defer="institution">
            <option value="">Public</option>
            @foreach($institutionsList as $key => $institution)
                <option value="{{$institution->uuid}}">{{$institution->name}}</option>
            @endforeach
        </select>
    </div>

    <button type="button" class="btn mydir-button" wire:click="checkResults" wire:loading.attr="disabled">Check results</button>

    <h3 class="mt-4 border-top pt-4">There are {{$this->resultsPreview}} matching records.</h3>

    <button type="button" class="btn mydir-button"  wire:click="generate" wire:loading.attr="disabled">Generate and send report</button>

    <div wire:target="generate">{{$message}}</div>

</div>
