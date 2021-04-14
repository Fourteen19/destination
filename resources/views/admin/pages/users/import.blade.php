@extends('admin.layouts.app')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Import Users for {{ $contentOwner  }}</h1>
            <p class="mydir-instructions">The form below allows the bulk import users to a selected institution. You may download a template to create your import file below.</p> <a href="{{ asset('admin/files/import/users_import_template.xlsx') }}" target="_blank"><i class="fas fa-download mr-2"></i>Download Import Template.</a>
            

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
    <div class="row">
        <div class="col-12">

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

        </div>
    </div>

    @endif



    {!! Form::open(['method' => 'POST','route' => ['admin.users.import'], 'files' => true]) !!}
    <div class="row">
        <div class="col-lg-8">
            {{-- if client admin level --}}
            @if (session()->get('adminAccessLevel') == 2)
                @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'N'])

            {{-- if system admin level --}}
            @elseif (session()->get('adminAccessLevel') == 3)
                @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'N'])
            @endif

            <div class="p-4">
            <h4>Formatting Instructions</h4>
            <ul>
                <li>For school pupils set the password as the unique student number</li>
                <li>The date of birth format is DD/MM/YY</li>
                <li>School year should be set as follows: 7, 8, 9, 10, 11, 12, 13, POST</li>
            </ul>
            </div>

            <div class="custom-file mt-3 mb-4">
            {!! Form::file('importFile', ['class' => 'custom-file-input']) !!}
            {!! Form::label('importFile', 'Choose File', ['class' => 'custom-file-label']); !!}
            </div>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn mydir-button">Import File</button>
        </div>

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
