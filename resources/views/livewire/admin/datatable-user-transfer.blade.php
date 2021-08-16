<div class="form-row">

    <div class="form-group col">
        <label class="inline-block w-32 font-bold">Institution:</label>
        <select name="institutionTo" id="institutionTo" wire:ignore wire:model.defer="institutionTo" class="form-control">
            <option value=''>Choose an institution</option>
            <option value='unallocated'>Unallocated</option>
            @foreach($institutions as $institution)
                <option value="{{ $institution->uuid }}" @if ($institution == $institution->uuid) selected @endif>{{ $institution->name }}</option>
            @endforeach
        </select>
    </div>

    @if ($displayTransferButton == 'Y')
        <div class="form-group col d-flex align-items-end">
            <button type="submit" wire:click="transfer" class="btn mydir-button-sm m-0">Transfer</button>
        </div>
    @endif

    <div x-data="{show:false}" x-show.transition.opacity.out.duration.1500ms="show" x-init="@this.on('transfered', () => {show = true; setTimeout(() => {show = false; }, 5000) })">{{$updateTxt}}</div>

</div>
