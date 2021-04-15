@extends('admin.layouts.app')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Import Users for {{ $contentOwner  }}</h1>
            <p class="mydir-instructions">Use the form below to import users.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            @include('admin.pages.includes.flash-message')
        </div>
    </div>

    @if (session()->has('failures'))

        <table class="table tale-danger">
            <tr>
                <th>Row</th>
                <th>Attributes</th>
                <th>Errors</th>
                <th>Values</th>
            </tr>

            @foreach (session()->get('failures') as $validation)
                <tr>
                    <td>{{ $validation->row() }}</td>
                    <td>{{ $validation->attribute() }}</td>
                    <td>
                        <ul>
                            @foreach($validation->errors() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </td>
                    </td>{{$validtion->values()[$validation->arrribute()]}}</td>
                <tr>
            @endforeach

        </table>

    @endif



    {!! Form::open(['method' => 'POST','route' => ['admin.users.import'], 'files' => true]) !!}

        {{-- if client admin level --}}
        @if (session()->get('adminAccessLevel') == 2)
            @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'N'])

        {{-- if system admin level --}}
        @elseif (session()->get('adminAccessLevel') == 3)
            @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'N'])
        @endif


        <div class="form-group">
            {!! Form::label('importFile', 'File', ['class' => 'anotherclass']); !!}
            {!! Form::file('importFile', ['class' => 'myclass']) !!}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn mydir-button">Submit</button>
        </div>

    {!! Form::close() !!}


    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.users.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
