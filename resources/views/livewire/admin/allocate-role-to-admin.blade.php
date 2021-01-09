<div>

    <div class="col-xs-12 col-sm-12 col-md-12" wire:ignore>
        <div class="form-group">
            {!! Form::label('role', 'Role'); !!}
            <select name="role" id="role" wire:model="role" class="form-control">
                <option value=''>Choose a role</option>
                @foreach($rolesList as $key => $role)
                    <option value="{{ $key }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>
    </div>


    @if ($displayClientsDropdown == 1)
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                {!! Form::label('client', 'Client'); !!}

                <select name="client" id="client" wire:model="client" class="form-control">
                    <option value=''>Choose a client</option>
                    @foreach($clientsList as $key => $client)
                        <option value="{{ $key }}">{{ $client }}</option>
                    @endforeach
                </select>

            </div>
        </div>
    @endif


    @if ($displayInstitutionsDropdown == 1)

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('institution') ? ' has-error' : '' }}">
                {!! Form::label('institution', 'Institutions'); !!}

                @foreach($institutionsList as $institution)
                    <div class="form-check">
                    {!! Form::checkbox('institutions[]', $institution->uuid, false, ['class' => 'form-check-input', 'id' => $institution->uuid, 'wire:model.lazy' => 'institutions' ]) !!}
                    <label class="form-check-label" for="{{$institution->uuid}}">{{$institution->name}}</label>
                    </div>
                @endforeach

            </div>
        </div>


    @endif
</div>
