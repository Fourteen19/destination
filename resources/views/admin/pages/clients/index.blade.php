@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

<h1 class="mb-4">Manage Clients</h1>

    <p>This screen lists the clients held on the platform</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.clients.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New client</a>
    </div>


    @include('admin.pages.includes.flash-message')

     <table id="client_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subdomain</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/pages/clients/list.js')}}"></script>
@endpush
