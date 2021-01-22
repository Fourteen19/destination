<div class="col-xs-12 col-sm-12 col-md-12" wire:ignore>
    <form wire:submit.prevent>
    <div class="form-group">

        <select name="client" id="client" wire:model="client" wire:submit="submit" class="form-control" >
            <option value=''>Choose a client</option>
            @foreach($clientsList as $key => $client)
                <option value="{{ $key }}">{{ $client }}</option>
            @endforeach
        </select>

    </div>
    </form>
</div>
