<div id="contact-details" class="tab-pane @if ($activeTab == "contact-details") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">

                @error('tel') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('tel', 'Telephone Number'); !!}
                {!! Form::text('tel', (empty($tel)) ? null : $tel, array('placeholder' => 'Telephone Number', 'class' => 'form-control', 'maxlength' => 20, 'wire:model.defer' => 'tel')) !!}

            </div>

            <div class="form-group">

                @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('email', 'Email Address'); !!}
                {!! Form::text('email', (empty($email)) ? null : $email, array('placeholder' => 'Email Address', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.lazy' => 'email')) !!}

            </div>

        </div>
    </div>
</div>
