@extends('frontend.layouts.app')

@section('content')

    Self Assessment<br>

    Terms<br>

    @include('frontend.pages.includes.flash-message')

    {!! Form::model(auth()->user(), ['method' => 'POST','route' => ['frontend.self-assessment.terms.update', auth()->user()->uuid]]) !!}

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('tagsTerms') ? ' has-error' : '' }}">
                {!! Form::label('tagsTerms', 'Term Tags'); !!}<br>

                @foreach($tagsTerms as $tagsTerm)
                    <label>{!! Form::checkbox('tagsTerms[]', $tagsTerm->name, ($userTermTags->where("id", $tagsTerm->id)->where("type", 'term'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsTerm->name]) !!} {{$tagsTerm->name}}</label><br>
                @endforeach

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" name="submit" value="next" class="btn btn-primary">Next</button>
        </div>

    </div>

    {!! Form::close() !!}
{{--

    @livewire('frontend.self-assessment-terms', [])

--}}

@endsection
