@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">{{ __('ck_admin.manage_sys_admins.title') }}</h1>

    <p>{{ __('ck_admin.manage_sys_admins.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.admins.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New admin</a>
    </div>

    @include('admin.pages.includes.flash-message')

    {{-- if NOT advisor/teacher level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Filter administrators</h3>
            </div>
            <div class="panel-body">
                <form method="POST" id="search-form" role="form">

                    {{-- if client admin level --}}
                    @if (session()->get('adminAccessLevel') == 2)
                        @livewire('admin.manage-admins-filter', ['institution' => ''])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.manage-admins-filter', ['institution' => ''])
                    @endif

                </form>
            </div>
        </div>

    @endif

    <table id="admin_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


</div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/pages/admins/list.js')}}"></script>
@endpush
