@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit User</h1>
            <p class="mydir-instructions">Use the form below to edit the user details.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    @include('admin.pages.includes.flash-message')

    @livewire('admin.add-edit-client-users')

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.users.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
/*
    function update_mask(){
        $('[data-mask]').inputmask();
    }

    $(document).ready(function(){
        update_mask();
    });

    window.addEventListener('contentChanged', event => {
        alert('1');
        update_mask();
    });
*/
</script>
@endpush
