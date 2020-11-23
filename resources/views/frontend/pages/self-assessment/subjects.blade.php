@extends('frontend.layouts.app')

@section('content')

    Self Assessment<br>

    Subjects<br>

    @include('frontend.pages.includes.flash-message')

    {!! Form::model(auth()->user(), ['method' => 'POST','route' => ['frontend.self-assessment.subjects.update', auth()->user()->uuid]]) !!}

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('tagsSubjects') ? ' has-error' : '' }}">
                {!! Form::label('tagsSubjects', 'Subject Tags'); !!}<br>

                @foreach($tagsSubjects as $tagsSubject)
                    <label>{!! Form::checkbox('tagsSubjects[]', $tagsSubject->name, ($userSubjectTags->where("id", $tagsSubject->id)->where("type", 'subject'))->count() == 1 ? true : false, ['class' => 'form-control', 'id' => $tagsSubject->name]) !!} {{$tagsSubject->name}}</label><br>
                @endforeach

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" name="submit" value="previous" class="btn btn-primary">Previous</button>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" name="submit" value="next" class="btn btn-primary">Finish</button>
        </div>

    </div>

    {!! Form::close() !!}
{{--

    @livewire('frontend.self-assessment-subjects', [])

--}}

@endsection