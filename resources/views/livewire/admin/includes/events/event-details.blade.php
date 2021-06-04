<div id="event-details" class="tab-pane px-0 @if ($activeTab == "event-details") active @else fade @endif" wire:key="event-details-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('event_title', 'Event Title'); !!}
                @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('event_title', $this->title, array('placeholder' => 'Event Title', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'title' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('date', 'Event Date'); !!}
                @error('event_date') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('date', $this->title, array('placeholder' => 'Event Date', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'event_date', 'id' => 'datepicker', 'onchange' => "this.dispatchEvent(new InputEvent('input'))" )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('start_time_hour', 'Event Start Time'); !!}
                @error('start_time_hour') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::select('start_time_hour', config('global.24-hour-clock.hours'), NULL, ['class' => "form-control", 'wire:model' => "start_time_hour", 'id' => "start_time_hour" ]); !!}
                : {!! Form::select('start_time_min', config('global.24-hour-clock.mins'), NULL, ['class' => "form-control", 'wire:model' => "start_time_min", 'id' => "start_time_min" ]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('end_time_hour', 'Event End Time'); !!}
                @error('end_time_hour') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::select('end_time_hour', config('global.24-hour-clock.hours'), NULL, ['class' => "form-control", 'wire:model' => "end_time_hour", 'id' => "end_time_hour" ]); !!}
                : {!! Form::select('end_time_min', config('global.24-hour-clock.mins'), NULL, ['class' => "form-control", 'wire:model' => "end_time_min", 'id' => "end_time_min" ]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('venue_name', 'Venue Name'); !!}
                @error('venue_name') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('venue_name', $this->venue_name, array('placeholder' => 'Venue Name', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'venue_name' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('town', 'Town / City'); !!}
                @error('town') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('town', $this->town, array('placeholder' => 'Venue Name', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'town' )) !!}
            </div>


            <div class="form-group">
                {!! Form::label('contact_name', 'Contact Name'); !!}
                @error('contact_name') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('contact_name', $this->title, array('placeholder' => 'Contact Name', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_name' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_number', 'Contact Number'); !!}
                @error('contact_number') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('contact_number', $this->title, array('placeholder' => 'Contact Number', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_number' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_email', 'Contact Email'); !!}
                @error('contact_email') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('contact_email', $this->title, array('placeholder' => 'Contact Email', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'contact_email' )) !!}
            </div>

            <div class="form-group">
                {!! Form::label('booking_link', 'Booking Link'); !!}
                @error('booking_link') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::text('booking_link', $this->title, array('placeholder' => 'Booking Link', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'booking_link' )) !!}
            </div>

        </div>
    </div>
</div>
