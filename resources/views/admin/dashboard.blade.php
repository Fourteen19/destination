@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('You are logged in!') }}</p>

                    <p>Your name is {{ Auth::user()->FullName }}</p>

                    <p>You are a 
                    @role('System Administrator', 'admin')
                        super admin
                    @elserole('Global Content Admin', 'admin')
                        Global Content Admin
                    @elserole('Client Admin', 'admin')
                        Client Admin
                    @elserole('Client Content Admin', 'admin')
                        Client Content Admin
                    @elserole('Advisor', 'admin')
                        Advisor
                    @elserole('Third Party Admin', 'admin')
                        Third Party Admin
                    @endrole
                    !</p>

                </div>

            </div>

            @include('admin.pages.includes.menu')
            
        </div>
    </div>
</div>
@endsection
