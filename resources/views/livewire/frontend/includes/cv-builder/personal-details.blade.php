<div id="personal-details" class="tab-pane @if ($activeTab == "personal-details") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

            <div class="px-lg-4">
                <div class="mb-5">{{ $staticContent['cv_personal_details_instructions'] }}</div>

                <div class="form-group row align-items-center mb-3">
                    <div class="col-lg-2">{!! Form::label('first_name', 'First Name:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('first_name', $this->first_name, array('placeholder' => 'First Name','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'first_name')) !!}
                    @error('first_name') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-center mb-3">
                    <div class="col-lg-2">{!! Form::label('last_name', 'Last Name:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('last_name', $this->last_name, array('placeholder' => 'Last Name','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'last_name')) !!}
                    @error('last_name') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-start mb-3">
                    <div class="col-lg-2">{!! Form::label('address', 'Address:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::textarea('address', $this->address, array('placeholder' => 'Address','class' => 'form-control form-control-lg', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'address')) !!}
                    <small class="px-2">Enter your address on a single line e.g. 100 Street Road, Smalltown, Bigcity, PO1 2CD</small>
                    @error('address') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-start mb-3">
                    <div class="col-lg-2">{!! Form::label('email', 'Email:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('email', $this->email, array('placeholder' => 'Email','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'email')) !!}
                    <small class="px-2">Provide an email address that you check regularly.</small>
                    @error('email') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-start mb-3">
                    <div class="col-lg-2">{!! Form::label('phone', 'Phone'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('phone', $this->phone, array('placeholder' => 'Phone','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'phone')) !!}
                    <small class="px-2">Make sure you provide a number where you can be easily reached or a message can be left for you.</small>
                    @error('phone') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <button type="button" wire:click.prevent="updateTab('personal-profile')" wire:loading.attr="disabled" class="btn platform-button ml-lg-4 mr-2">Next<i class="fas fa-caret-right ml-2"></i></button>
        </div>
    </div>

</div>
