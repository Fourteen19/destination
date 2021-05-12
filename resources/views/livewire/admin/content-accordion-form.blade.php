<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "article-settings") active @endif @if($errors->hasany(['slug', 'title'])) error @endif" data-toggle="tab" href="#article-settings" data-tab="article-settings" wire:click="updateTab('article-settings')">Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "banner-image") active @endif @if($errors->hasany(['banner'])) error @endif" data-toggle="tab" href="#banner-image" data-tab="banner-image" wire:click="updateTab('banner-image')">Banner Image</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "main-content") active @endif @if($errors->hasany(['subheading', 'lead', 'body'])) error @endif" data-toggle="tab" href="#main-content" data-tab="main-content" wire:click="updateTab('main-content')">Main Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "questions") active @endif @if($errors->hasany(['relatedQuestions.*'])) error @endif" data-toggle="tab" href="#questions" data-tab="questions" wire:click="updateTab('questions')">Questions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "links") active @endif @if($errors->hasany(['relatedLinks.*'])) error @endif" data-toggle="tab" href="#links" data-tab="links" wire:click="updateTab('links')">Links</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "downloads") active @endif @if($errors->hasany(['relatedDownloads.*'])) error @endif" data-toggle="tab" href="#downloads" data-tab="downloads" wire:click="updateTab('downloads')">Downloads</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "images") active @endif @if($errors->hasany(['relatedImages.*'])) error @endif" data-toggle="tab" href="#images" wire:key="images-tab" wire:click="updateTab('images')">Images</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "read_next_article") active @endif" data-toggle="tab" href="#read_next_article" data-tab="read_next_article" wire:key="read_next_article-tab" wire:click="updateTab('read_next_article')">Read Next Article</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "summary") active @endif @if($errors->hasany(['summary_heading', 'summary_text'])) error @endif" data-toggle="tab" href="#summary" data-tab="summary" wire:click="updateTab('summary')">Summary</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "filters") active @endif" data-toggle="tab" href="#filters" data-tab="filters" wire:click="updateTab('filters')">Filters</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "keywords") active @endif" data-toggle="tab" href="#keywords" data-tab="keywords" wire:click="updateTab('keywords')">Keywords</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "content_preview") active @endif" data-toggle="tab" href="#content_preview" data-tab="content_preview" wire:key="content_preview-tab" wire:click="updateTab('content_preview')">Content Preview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "summary_preview") active @endif" data-toggle="tab" href="#summary_preview" data-tab="summary_preview" wire:key="summary_preview-tab" wire:click="updateTab('summary_preview')">Summary Preview</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.content.article-settings')

        @include('livewire.admin.includes.content.main-content')

        @include('livewire.admin.includes.content.banner-image')

        @include('livewire.admin.includes.content.questions')

        @include('livewire.admin.includes.content.links')

        @include('livewire.admin.includes.content.downloads')

        @include('livewire.admin.includes.content.images')

        @include('livewire.admin.includes.content.read-next-article')

        @include('livewire.admin.includes.content.summary')

        @include('livewire.admin.includes.content.filters')

        @include('livewire.admin.includes.content.keywords')

        @include('livewire.admin.includes.content.content_preview_accordion')

        @include('livewire.admin.includes.content.summary_preview')

    </div>


    @include('livewire.admin.includes.content.submit')

</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush


@push('scripts')
<script>

    /****************/

    // input
    let inputId = '';

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image-banner').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'banner_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image-summary').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'summary_image';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        if (inputId == 'banner_image'){
            livewire.emit('make_banner_image', $url);
        } else if (inputId == 'summary_image'){
            livewire.emit('make_summary_image', $url);
        } else {

            if (inputId.startsWith('file_relatedDownloads')){
                {{-- adds the file name in the input field --}}
                document.getElementById(inputId).value = $url;
                livewire.emit('make_related_download', inputId, $url);
            } else if (inputId.startsWith('file_relatedImages')){
                {{-- adds the file name in the input field --}}
                document.getElementById(inputId).value = $url;
                livewire.emit('make_related_image', inputId, $url);

            }

        }

    }

    /***************/


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

        link_assume_external_targets: 'https',
        relative_urls: false,
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
                focusedElement = document.activeElement;
                console.log(focusedElement.getAttribute('data-tab'));
                if (focusedElement.getAttribute('data-tab')){
                    @this.set('activeTab', focusedElement.getAttribute('data-tab'));
                }

                @this.set('body', tinymce.get("body").getContent());
            });
        }
    });


    addTinyMCE();


    window.addEventListener('componentUpdated', event => {
        addTinyMCE();
    });



    // Add TinyMCE
    function addTinyMCE(){


/*         tinymce.init({
            selector: '.tiny_question_title',
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

            link_assume_external_targets: 'https',
            relative_urls: false,
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
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('blur', function(e) {
                    myStr = tinymce.activeEditor.id;
                    id = myStr.match(/\d+/);
                    @this.set('relatedQuestions.'+id+'.title', tinymce.get('relatedQuestions['+id+'][title]').getContent());
                });
            }

        }); */


        tinymce.init({
            selector: '.tiny_question_text',
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

            link_assume_external_targets: 'https',
            relative_urls: false,
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
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('blur', function(e) {

                    focusedElement = document.activeElement;
                    console.log(focusedElement.getAttribute('data-tab'));
                    if (focusedElement.getAttribute('data-tab')){
                        @this.set('activeTab', focusedElement.getAttribute('data-tab'));
                    }

                    myStr = tinymce.activeEditor.id;
                    id = myStr.match(/\d+/);
                    @this.set('relatedQuestions.'+id+'.text', tinymce.get('relatedQuestions['+id+'][text]').getContent());
                });
            }

        });

    }

</script>
@endpush
