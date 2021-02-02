<div class="col-xs-12 col-sm-12 col-md-12 border-left">
    <form wire:submit.prevent>
    <div class="form-inline mb-0">
<label class="mr-2"><i class="fas fa-user-tie mr-2"></i>Set client:</label>
        @error('client') <div class="text-danger error">{{ $message }}</div>@enderror
        {!! Form::select('client', $clientsList, $client, array('class' => 'form-control', 'name' => 'client', 'wire:model' => 'client')) !!}

    </div>
    </form>
</div>
