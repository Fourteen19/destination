<div id="contact-details" class="tab-pane @if ($activeTab == "contact-details") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">

{{--                 <label for="tel">Telephone Number</label>
                <input placeholder="Telephone Number" class="form-control" maxlength="255" wire:model="staticClientContent.tel" name="tel" type="tel" id="tel">
 --}}
                @error('tel') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('tel', 'Telephone Number'); !!}
                {!! Form::text('tel', (empty($staticClientContent->tel)) ? null : $staticClientContent->tel, array('placeholder' => 'Telephone Number', 'class' => 'form-control', 'maxlength' => 20, 'wire:model' => 'staticClientContent.tel')) !!}

            </div>

            <div class="form-group">

{{--                <label for="email">Email Address</label>
                <input placeholder="Email Address" class="form-control" maxlength="255" wire:model.lazy="email" name="email" type="email" id="email">
--}}

                @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('email', 'Email Address'); !!}
                {!! Form::text('email', (empty($staticClientContent->email)) ? null : $staticClientContent->email, array('placeholder' => 'Email Address', 'class' => 'form-control', 'maxlength' => 255, 'wire:model' => 'staticClientContent.email')) !!}

            </div>

        </div>
    </div>
</div>
