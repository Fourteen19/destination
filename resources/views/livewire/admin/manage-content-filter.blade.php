<div class="form-row">

     <div class="form-group col">
        <label class="inline-block w-32 font-bold">Content Type:</label>
        <select name="type" id="type" wire:model.defer="type" class="form-control">
            <option value=''>Choose a template</option>
            @foreach($types as $key => $type)
                <option value="{{ $key }}">{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col d-flex align-items-end">
        <button type="submit" class="btn mydir-button-sm m-0">Search</button>
    </div>

</div>
