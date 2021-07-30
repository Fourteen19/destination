@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Create Vacancy Role</h1>
            <p class="mydir-instructions">From this screen you can enter all the details required to create a vacancy role within the system.</p>

        </div>
    </div>

    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <div class="row">
        <div class="col-lg-6">

            @include('admin.pages.includes.flash-message')

            {!! Form::model($vacancyRole, ['method' => 'POST','route' => ['admin.vacancies.roles.store']]) !!}

                @include('admin.pages.vacancies.roles.form')

            {!! Form::close() !!}

        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.vacancies.roles.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>

</div>
@endsection
