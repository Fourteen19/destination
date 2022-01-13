<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "colours") active @endif" data-toggle="tab" href="#colours" wire:key="colours-tab" wire:click="updateTab('colours')">Client colours</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "logo") active @endif" data-toggle="tab" href="#logo" wire:key="logo-tab" wire:click="updateTab('logo')">Logo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "fonts") active @endif" data-toggle="tab" href="#fonts" wire:key="fonts-tab" wire:click="updateTab('fonts')">Font settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "apps") active @endif" data-toggle="tab" href="#apps" wire:key="apps-tab" wire:click="updateTab('apps')">Chat App</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.client-settings.colour')

        @include('livewire.admin.includes.client-settings.logo')

        @include('livewire.admin.includes.client-settings.fonts')

        @include('livewire.admin.includes.client-settings.apps')

    </div>

    @include('livewire.admin.includes.client-settings.submit')

</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush


@push('scripts')
<script>

    /*****************/

    // input
    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image-logo').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'logo_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });


    // set file link
    function fmSetLink($url) {
        if (inputId == 'logo_image'){
            livewire.emit('make_logo_image', $url);
        }
    }

</script>
@endpush
