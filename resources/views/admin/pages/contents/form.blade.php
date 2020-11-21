<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('template') ? ' has-error' : '' }}">
            {!! Form::label('template', 'Templates available'); !!}  <br><br><br>

            @foreach($templates as $template)
                <label>{!! Form::radio('template', $template->name, null, ['class' => 'form-control', 'id' => $template->name]) !!} {{$template->name}}</label>

                {{$template->description}}

                <br><br><br>
            @endforeach

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>
