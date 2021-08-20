<div id="personal-details" class="tab-pane @if ($activeTab == "personal-details") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('first_name', 'First Name'); !!}
                {!! Form::text('first_name', $this->first_name, array('placeholder' => 'First Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'first_name')) !!}
                @error('first_name') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('last_name', 'Last Name'); !!}
                {!! Form::text('last_name', $this->last_name, array('placeholder' => 'Last Name','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'last_name')) !!}
                @error('last_name') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('address', 'Address'); !!}
                {!! Form::textarea('address', $this->address, array('placeholder' => 'Address','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'address')) !!}
                @error('address') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('email', 'Email'); !!}
                {!! Form::text('email', $this->email, array('placeholder' => 'Email','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'email')) !!}
                @error('email') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('phone', 'Phone'); !!}
                {!! Form::text('phone', $this->phone, array('placeholder' => 'Phone','class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'phone')) !!}
                @error('phone') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('personal-profile')" wire:loading.attr="disabled" class="btn mydir-button mr-2">Next</button>
        </div>
    </div>

</div>
