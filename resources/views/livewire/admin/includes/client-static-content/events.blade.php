<div id="events" class="tab-pane @if ($activeTab == "events") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group">
                {!! Form::label('no_event', 'Fall back text if there are less than 2 events in system'); !!}
                {!! Form::textarea('no_event', $no_event, array('placeholder' => 'Enter fall back text','class' => 'form-control', 'wire:model.defer' => 'no_event')) !!}
            </div>

        </div>
    </div>
</div>
