<div id="event-content" class="tab-pane px-0 @if ($activeTab == "event-content") active @else fade @endif" wire:key="event-content-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group @error('lead_para') has-error @enderror">
                @error('lead_para') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('lead', 'Lead Paragraph'); !!}
                {!! Form::textarea('lead', (!isset($event->lead_para)) ? null : $event->lead_para, array('placeholder' => 'Lead Paragraph', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'lead_para')) !!}
            </div>

            <div wire:ignore>
                <div class="form-group">
                @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('description', 'Event description text'); !!}
                {!! Form::textarea('description', (!isset($event->description)) ? null : $event->text, array('placeholder' => 'Event description text', 'class' => 'form-control tiny_desc', 'wire:model.defer' => 'description')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('map', 'Embed Google Map URL'); !!}
                {!! Form::textarea('map', (!isset($event->map)) ? null : $event->map, array('placeholder' => 'Map URL i.e. https://www.link.com','class' => 'form-control', 'maxlength' => 5000, 'wire:model.defer' => 'map' )) !!}
                <small class="mt-3 d-inline-block">Having entered a postcode on Google Maps click the "Share" button. In the share window select the "Embed a map" tab. Click on "Copy HTML" and paste the code into the above field.</small>
            </div>

        </div>
    </div>
</div>
