@extends('frontend.layouts.app')

@section('content')

    Self Assessment<br>

    Routes<br>

    @include('frontend.pages.includes.flash-message')

    {!! Form::model(auth()->user(), ['method' => 'POST','route' => ['frontend.self-assessment.routes.update', auth()->user()->uuid]]) !!}

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group{{ $errors->has('tagsRoutes') ? ' has-error' : '' }}">
            {!! Form::label('tagsRoutes', 'Route Tags'); !!}

            @foreach($tagsRoutes as $tagsRoute)
                <label>{!! Form::checkbox('tagsRoutes[]', $tagsRoute->name, ($userRouteTags->where("id", $tagsRoute->id)->where("type", 'route'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsRoute->name]) !!} {{$tagsRoute->name}}</label>
            @endforeach

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" name="submit" value="previous" class="btn btn-primary">Previous</button>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" name="submit" value="next" class="btn btn-primary">Next</button>
    </div>

</div>

{!! Form::close() !!}

@endsection
