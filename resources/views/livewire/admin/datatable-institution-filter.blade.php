<div class="form-row">

    <div class="form-group col">
        <label class="inline-block w-32 font-bold">Institution:</label>
        <select name="institution" id="institution" wire:model.defer="institution" class="form-control">
            <option value=''>Choose an institution</option>
            @foreach($institutions as $institution)
                <option value="{{ $institution->uuid }}" @if ($institution == $institution->uuid) selected @endif>{{ $institution->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col d-flex align-items-end">
        <button type="submit" class="btn mydir-button-sm m-0">Search</button>
    </div>

</div>
