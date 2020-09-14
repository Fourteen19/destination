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

                    {{ __('You are logged in!') }}

                    @if (Auth::user()->isSystemAdmin())
                        I am a system admin user
                    @elseif (Auth::user()->isAdmin())
                        I am a admin user
                    @elseif (Auth::user()->isEditor())
                        I am a editor user
                    @endif
                </div>

            </div>


            @if (Auth::user()->isSystemAdmin())
                @include('admin.menus.system_admin_menu')
            @elseif (Auth::user()->isAdmin())
                @include('admin.menus.admin_menu')
            @elseif (Auth::user()->isEditor())
                @include('admin.menus.editor_menu')
            @endif

        </div>
    </div>
</div>
@endsection
