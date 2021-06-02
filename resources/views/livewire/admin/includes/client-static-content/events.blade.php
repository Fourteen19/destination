<div id="events" class="tab-pane @if ($activeTab == "events") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group">
                {!! Form::label('no_event', 'Text if less than 2 events in homepage'); !!}
                {!! Form::textarea('no_event', $no_event, array('placeholder' => 'Text if less than 2 events in homepage','class' => 'form-control', 'wire:model.defer' => 'no_event')) !!}
            </div>

        </div>
    </div>
</div>
