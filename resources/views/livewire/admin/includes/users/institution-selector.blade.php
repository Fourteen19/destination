<div id="institution" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('institution_id', 'Institution ID'); !!}
                {!! Form::text('institution_id', 1, array('class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <label for="client_name">Set client</label>
                <select class="form-control" wire:model.lazy="client_name" id="client_name" name="client_name">
                    <option value="Please select">Please select</option>
                    <option value="Client name A">Client name A</option>
                    <option value="Client name B">Client name B</option>
                </select>
            </div>

            <div class="form-group">
                <label for="inst_name">Set institution</label>
                <select class="form-control" wire:model.lazy="inst_name" id="inst_name" name="inst_name">
                    <option value="Please select">Please select</option>
                    <option value="Institution name A">Institution name A</option>
                    <option value="Institution name B">Institution name B</option>
                </select>
            </div>

            <div class="form-inline">
                    <label class="mr-2">Adviser:</label>[Adviser Name]
            </div>

        </div>
    </div>
</div>
