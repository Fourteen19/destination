<div class="form-row">

    <div class="form-group col">
        <label class="inline-block w-32 font-bold">Transfer from (Institution):</label>
        <select name="institution" id="institution" wire:model.defer="institution" class="form-control">
            <option value=''>Choose an institution</option>
            <option value='unallocated'>Unallocated</option>
            @foreach($institutions as $institution)
                <option value="{{ $institution->uuid }}" @if ($institution == $institution->uuid) selected @endif>{{ $institution->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col">
        <label class="inline-block w-32 font-bold">Year:</label>
        <select name="year" id="year" wire:model.defer="year" class="form-control">
            <option value=''>Choose a year</option>
            <option value='7'>7</option>
            <option value='8'>8</option>
            <option value='9'>9</option>
            <option value='10'>10</option>
            <option value='11'>11</option>
            <option value='12'>12</option>
            <option value='13'>13</option>
            <option value='14'>Post</option>
        </select>
    </div>

    @if ($displaySearchButton == 'Y')
        <div class="form-group col d-flex align-items-end">
            <button type="submit" class="btn mydir-button-sm m-0">Search</button>
        </div>
    @endif

</div>
