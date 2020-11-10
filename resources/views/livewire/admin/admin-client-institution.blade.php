<div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
            {!! Form::label('role', 'Role compononent'); !!}
            {!! Form::select('role', $roles, isset($role) ? $role : '', array('class' => 'form-control', 'id' => 'role', 'wire:model' => "adminRole")) !!}
        </div>
    </div>

    @if ($displayClientDropdown == 1)
        <div class="col-xs-12 col-sm-12 col-md-12" id="client_container">
            <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                {!! Form::label('client', 'Client'); !!}
                <select name="client" id="client" wire:model="client" class="form-control">
                    <option value=''>Choose a client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->uuid }}">{{ $client->name }}</option>
                    @endforeach
                </select>
     {{--
                {!! Form::select('client', $clients = [],[], array('class' => 'form-control', 'id' => 'aclient')) !!}
    --}}
            </div>
        </div>
    @endif

    @if ($displayInstitutionDropdown == 1)
        <div class="col-xs-12 col-sm-12 col-md-12" id="institution_container">
            <div class="form-group">
                {!! Form::label('institution', 'Institution'); !!}
                <select name="client" id="client" wire:model="client" class="form-control">
                    <option value=''>Choose an institution</option>
                    @foreach($institutions as $institution)
                        <option value="{{ $institution->uuid }}">{{ $institution->name }}</option>
                    @endforeach
                </select>
{{--
    {!! Form::select('institution[]', $institutions = [],[], array('class' => 'form-control', 'id' => 'ainstitution', 'size'=>10, 'multiple'=>'multiple')) !!}
--}}

            </div>
        </div>
    @endif
</div>
