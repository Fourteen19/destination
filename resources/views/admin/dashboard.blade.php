@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col mb-5">
            <h1>Welcome {{ Auth::guard('admin')->user()->first_name }}</h1>
            <h2>You are logged in - your role is: {{ Auth::guard('admin')->user()->getRoleNames()->first() }}</h2>
        </div>

    </div>

</div>




<div class="container-fluid">

        @include('admin.pages.includes.menu')

</div>

@endsection
