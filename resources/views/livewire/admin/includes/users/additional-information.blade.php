<div id="additional-info" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('roni', 'RONI (Risk of NEET indicator)'); !!}
                {!! Form::text('roni', null, array('placeholder' => 'RONI (Risk of NEET indicator)','class' => 'form-control')) !!}
            </div>

            <div class="form-group mb-3">
                {!! Form::label('rodi', 'RODI (Risk of Dropping out indicator)'); !!}
                {!! Form::text('rodi', null, array('placeholder' => 'RODI (Risk of Dropping out indicator)','class' => 'form-control')) !!}
            </div>

            <hr>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" value="" id="neet-1618">
                <label class="form-check-label" for="neet-1618">
                    NEET 16-18
                </label>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" value="" id="neet-18plus">
                <label class="form-check-label" for="neet-18plus">
                    NEET 18+
                </label>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" value="" id="below-level-2">
                <label class="form-check-label" for="below-level-2">
                    Below Level 2
                </label>
            </div>

        </div>
    </div>
</div>
