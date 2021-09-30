<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">

        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "contact-details") active @endif @if($errors->hasany(['telephone', 'email'])) error @endif" data-toggle="tab" href="#contact-details" wire:click="updateTab('contact-details')">Contact details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "legal") active @endif" data-toggle="tab" href="#legal" wire:click="updateTab('legal')">Legal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "public-content") active @endif" data-toggle="tab" href="#public-content" wire:click="updateTab('public-content')">Public content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "self-assessment") active @endif" data-toggle="tab" href="#self-assessment" wire:click="updateTab('self-assessment')">Self assessment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "logged-in-content") active @endif" data-toggle="tab" href="#loggedin" wire:click="updateTab('logged-in-content')">Logged in content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "login-box") active @endif @if($errors->hasany(['loginBoxBanner'])) error @endif" data-toggle="tab" href="#login-box" wire:click="updateTab('login-box')">Login box</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "free-articles") active @endif" data-toggle="tab" href="#free-articles" wire:click="updateTab('free-articles')">Free Articles Message</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "work-experience") active @endif" data-toggle="tab" href="#work-experience" wire:click="updateTab('work-experience')">Work Experience</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "events") active @endif" data-toggle="tab" href="#events" wire:click="updateTab('events')">Events</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "vacancies") active @endif" data-toggle="tab" href="#vacancies" wire:click="updateTab('vacancies')">Vacancies</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "cv-builder") active @endif" data-toggle="tab" href="#cv-builder" wire:click="updateTab('cv-builder')">CV Builder</a>
        </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.client-static-content.contact-details')

        @include('livewire.admin.includes.client-static-content.legal')

        @include('livewire.admin.includes.client-static-content.public-content')

        @include('livewire.admin.includes.client-static-content.self-assessment')

        @include('livewire.admin.includes.client-static-content.logged-in-content')

        @include('livewire.admin.includes.client-static-content.login-block')

        @include('livewire.admin.includes.client-static-content.free-articles')

        @include('livewire.admin.includes.client-static-content.work-experience')

        @include('livewire.admin.includes.client-static-content.events')

        @include('livewire.admin.includes.client-static-content.vacancies')

        @include('livewire.admin.includes.client-static-content.cv-builder')

    </div>

    @include('livewire.admin.includes.client-static-content.submit')

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
        menubar: false,
        paste_as_text: true,
        height: 400,
        custom_colors: false,
        plugins: [
            'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media image nonbreaking',
            'save table directionality emoticons template paste'
        ],

        toolbar1: "bold italic underline strikethrough forecolor | alignleft aligncenter alignright alignjustify | formatselect",
        toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image code | table | hr removeformat | subscript superscript | fullscreen",

        color_map: [
            '444444', 'Default',
            '777777', 'Gray',
            '865e9d', 'Corporate Purple',
            '489fdf', 'Blue',
            'ff7500', 'Orange',
            '78be21', 'Green',
            '28334a', 'Navy',
            'c3366f', 'Pink'
        ],


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
                field_id = tinymce.activeEditor.id;
                @this.set(field_id, tinymce.get(field_id).getContent());
            });
        }
    });

</script>
@endpush
