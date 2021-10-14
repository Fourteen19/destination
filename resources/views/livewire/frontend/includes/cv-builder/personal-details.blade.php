<div id="personal-details" class="tab-pane @if ($activeTab == "personal-details") active @else fade @endif">
    <div class="row">
        <div class="col-lg-12">

            <div class="px-lg-4">
                <div class="mb-5">{!! $staticContent['cv_personal_details_instructions'] !!}</div>

                <div class="form-group row align-items-center mb-3">
                    <div class="col-lg-2">{!! Form::label('first_name', 'First name:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('first_name', $this->first_name, array('placeholder' => 'First name','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'first_name')) !!}
                    @error('first_name') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-center mb-3">
                    <div class="col-lg-2">{!! Form::label('last_name', 'Last name:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('last_name', $this->last_name, array('placeholder' => 'Last name','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'last_name')) !!}
                    @error('last_name') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-start mb-3">
                    <div class="col-lg-2">{!! Form::label('address', 'Address:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('address', $this->address, array('placeholder' => 'Address','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'address')) !!}
                    <div class="t14 mt-2 px-2"><i>Enter your address on a single line e.g. 100 Street Road, Smalltown, Bigcity, PO1 2CD</i></div>
                    @error('address') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-start mb-3">
                    <div class="col-lg-2">{!! Form::label('email', 'Email:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('email', $this->email, array('placeholder' => 'Email','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'email')) !!}
                    <div class="t14 mt-2 px-2"><i>Provide an email address that you check regularly.</i></div>
                    @error('email') <div class="text-danger error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-12"><div class="cv-split"></div></div>
                </div>

                <div class="form-group row align-items-start mb-3">
                    <div class="col-lg-2">{!! Form::label('phone', 'Phone number:'); !!}</div>
                    <div class="col-lg-6">
                    {!! Form::text('phone', $this->phone, array('placeholder' => 'Phone number','class' => 'form-control form-control-lg', 'maxlength' => 255, 'wire:model.defer' => 'phone')) !!}
                    <div class="t14 mt-2 px-2"><i>Make sure you provide a number where you can be easily reached or a message can be left for you.</i></div>
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
