<div class="col-xs-12 col-sm-12 col-md-12">
    <form wire:submit.prevent>
    <div class="form-group">

        @error('client') <div class="text-danger error">{{ $message }}</div>@enderror
        {!! Form::select('client', $clientsList, $client, array('class' => 'form-control', 'name' => 'client', 'wire:model' => 'client')) !!}

    </div>
    </form>
</div>
