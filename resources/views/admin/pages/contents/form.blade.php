
        <div class="form-group{{ $errors->has('template') ? ' has-error' : '' }}">
            <div class="mb-3">{!! Form::label('template', 'Templates'); !!}</div>

            @foreach($templates as $template)
                <div class="form-check">
                {!! Form::radio('template', $template->name, null, ['class' => 'form-check-input', 'id' => $template->name]) !!}
                <label class="form-check-label font-weight-bold mr-3" for="{{$template->name}}">
                    {{$template->name}}

                </label>
                <small>{{$template->description}}</small>
                </div>
                <hr>
            @endforeach
</div>
        <button type="submit" class="btn mydir-button">Select template</button>