<div id="additional-info" class="tab-pane fade">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                {!! Form::label('roni', 'RONI (Risk of NEET indicator)'); !!}
                {!! Form::text('roni', $this->roni, array('placeholder' => 'RONI (Risk of NEET indicator)','class' => 'form-control', 'wire:model.defer' => 'roni')) !!}
            </div>

            <div class="form-group mb-3">
                {!! Form::label('rodi', 'RODI (Risk of Dropping out indicator)'); !!}
                {!! Form::text('rodi', $this->rodi, array('placeholder' => 'RODI (Risk of Dropping out indicator)','class' => 'form-control', 'wire:model.defer' => 'rodi')) !!}
            </div>

            <hr>

            @foreach($tagsNeet as $tag)
                <div class="form-check mb-4">
                    {!! Form::checkbox('tagsNeet[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['uuid'], 'wire:model.defer' => 'usertagsNeet' ]) !!}
                    <label class="form-check-label" for="{{$tag['uuid']}}">{{$tag['name'][app()->getLocale()]}}</label>
                </div>
            @endforeach

        </div>
    </div>
</div>
