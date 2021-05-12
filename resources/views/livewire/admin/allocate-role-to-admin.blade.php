<div class="w-100">

    <div class="col-xs-12 col-sm-12 col-md-12" wire:ignore>
        <div class="form-group">
            {!! Form::label('role', 'Role'); !!}

            <select name="role" id="role" wire:model="role" class="form-control">
                <option value=''>Choose a role</option>
                @foreach($rolesList as $key => $roleName)
                    <option value="{{ $key }}">{{ $roleName }}</option>
                @endforeach
            </select>

        </div>
    </div>


    @if ($displayContactMe == 1)
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-split"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group form-check">
                <input type="checkbox" name="contact_me" class='form-check-input' value="1" id='contactMe' wire:model.lazy='contactMe' />
                <label class="form-check-label" for="contactMe"><b>Can be contacted by users</b></label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-split"></div>
        </div>
    @endif


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
                    @if ($role == config('global.admin_user_type.Advisor'))
                        {!! Form::checkbox('institutions[]', $institution['uuid'], false, ['class' => 'form-check-input', 'id' => $institution['uuid'], 'wire:model.defer' => 'institutions', ( ( !in_array($uuid, $institution['admin_uuid']) && ($institution['current_nb_allocation'] > 0) ) ) ? 'disabled' : '' ]) !!}
                        <label class="form-check-label" for="{{$institution['uuid']}}">{{$institution['name']}} @if (!empty($institution['advisor_name'])) <b>({{$institution['advisor_name']}})</b> @endif</label>
                    @else
                        {!! Form::checkbox('institutions[]', $institution['uuid'], false, ['class' => 'form-check-input', 'id' => $institution['uuid'], 'wire:model.defer' => 'institutions' ]) !!}
                        <label class="form-check-label" for="{{$institution['uuid']}}">{{$institution['name']}} @if (!empty($institution['advisor_name'])) <b>({{$institution['advisor_name']}})</b> @endif</label>
                    @endif
                    </div>
                @endforeach

            </div>
        </div>

    @endif


</div>
