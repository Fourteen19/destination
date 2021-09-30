<div id="events" class="tab-pane @if ($activeTab == "events") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group">
                {!! Form::label('no_event', 'Fall back text if there are less than 2 events in system'); !!}
                {!! Form::textarea('no_event', $no_event, array('placeholder' => 'Enter fall back text','class' => 'form-control', 'wire:model.defer' => 'no_event')) !!}
            </div>

            <div class="form-group">
                @error('event_email_notification') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('notifications', 'Please enter a semicolon separated list of administrator emails who should be notified when a third-party admin creates or updates an event'); !!}
                {!! Form::textarea('notifications', $event_email_notification, array('placeholder' => 'admin1@mydirections.co.uk;admin2@mydirections.co.uk','class' => 'form-control', 'wire:model.defer' => 'event_email_notification')) !!}
            </div>

        </div>
    </div>
</div>
