@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Public Homepage</h1>
            <p class="mydir-instructions">Use this screen to control all content showing on your public homepage.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


    <form wire:submit.prevent="submit">

        @livewire('admin.page-homepage-form')

    </form>

</div>
@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush


@push('scripts')
<script>

    // input
    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image-banner').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'banner_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });


    // set file link
    function fmSetLink($url) {
        if (inputId == 'banner_image'){
            livewire.emit('make_banner_image', $url);
        }
    }

</script>
@endpush
