<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">

        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "contact-details") active @endif @if($errors->hasany(['telephone', 'email'])) error @endif" data-toggle="tab" href="#contact-details" wire:click="updateTab('contact-details')">Contact details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" @if ($activeTab == "legal") active @endif data-toggle="tab" href="#legal" wire:click="updateTab('legal')">Legal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" @if ($activeTab == "public-content") active @endif data-toggle="tab" href="#public-content" wire:click="updateTab('public-content')">Public content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" @if ($activeTab == "self-assessment") active @endif data-toggle="tab" href="#self-assessment" wire:click="updateTab('self-assessment')">Self assessment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" @if ($activeTab == "logged-in-content") active @endif data-toggle="tab" href="#loggedin" wire:click="updateTab('logged-in-content')">Logged in content</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.client-static-content.contact-details')

        @include('livewire.admin.includes.client-static-content.legal')

        @include('livewire.admin.includes.client-static-content.public-content')

        @include('livewire.admin.includes.client-static-content.self-assessment')

        @include('livewire.admin.includes.client-static-content.logged-in-content')

    </div>


    @if ($errors->any())
    <div class="row">
        <div class="col-lg-8">
            <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>There are some errors in your content</div>
        </div>
    </div>
    @endif

    @if (Session::has('fail'))
    <div class="row">
        <div class="col-lg-8">
        <div class="text-danger error"><i class="fas fa-info-circle mr-2"></i>Your data could not be saved</div>
        </div>
    </div>
    @endif

    @if (Session::has('success'))
    <div class="row">
        <div class="col-lg-8">
        <div class="mydir-success"><i class="fas fa-check-circle mr-2"></i>Your data has been saved!</div>
        </div>
    </div>
    @endif

    <div class="row">
        <button type="button" wire:loading.attr="disabled" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>
    </div>

</div>


@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.1.0/dist/livewire-sortable.js"></script>
@endpush


@push('scripts')
<script>

tinymce.init({
        selector: 'textarea.tiny_body',
        plugins: [
            'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media image nonbreaking',
            'save table directionality emoticons template paste'
        ],
        relative_urls: true,
        document_base_url: '{{ Config::get('app.url') }}',
        file_picker_callback (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

            tinymce.activeEditor.windowManager.openUrl({
            url : '/file-manager/tinymce5',
            title : 'Laravel File manager',
            width : x * 0.8,
            height : y * 0.8,
            onMessage: (api, message) => {
                callback(message.content, { text: message.text })
            }
            })
        },
        setup: function(editor) {
            editor.on('blur', function(e) {
                @this.set('body', tinymce.get("body").getContent());
            });
        }
    });

</script>
@endpush
