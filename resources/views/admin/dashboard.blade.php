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

                    @if (Auth::user()->client_id)
                        <p>Client: {{ Auth::user()->client->name }}</p>
                    @endif

                    @if (Auth::user()->institution_id)
                        <p>Instution: {{ Auth::user()->institution->name }}</p>
                    @endif

                    <p>You user type is: {{ Auth::user()->getRoleNames()->first() }}!!</p>

                </div>

            </div>

            @include('admin.pages.includes.menu')
            
        </div>
    </div>
</div>
@endsection
