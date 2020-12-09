@extends('frontend.layouts.app')

@section('content')

    Self Assessment<br>

    Sectors<br>

    @include('frontend.pages.includes.flash-message')

    {!! Form::model(auth()->user(), ['method' => 'POST','route' => ['frontend.self-assessment.sectors.update', auth()->user()->uuid]]) !!}

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('tagsSectors') ? ' has-error' : '' }}">
                {!! Form::label('tagsSectors', 'Sector Tags'); !!}

                @foreach($tagsSectors as $tagsSector)
                    <label>{!! Form::checkbox('tagsSectors[]', $tagsSector->name, ($userSectorTags->where("id", $tagsSector->id)->where("type", 'sector'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsSector->name]) !!} {{$tagsSector->name}}</label>
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
