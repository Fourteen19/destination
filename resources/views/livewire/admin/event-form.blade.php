<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "event-details") active @endif @if($errors->hasany(['title', 'event_date'])) error @endif" data-toggle="tab" href="#event-details" wire:click="updateTab('event-details')">Event details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "banner-image") active @endif @if($errors->hasany(['banner', 'banner_alt'])) error @endif" data-toggle="tab" href="#banner-image" data-tab="banner-image" wire:key="banner-image-tab" wire:click="updateTab('banner-image')">Banner Image</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "event-content") active @endif @if($errors->hasany(['lead_para', 'description'])) error @endif" data-toggle="tab" href="#event-content" wire:click="updateTab('event-content')">Event content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "videos") active @endif @if($errors->hasany(['relatedVideos.*'])) error @endif" data-toggle="tab" href="#videos" data-tab="videos" wire:key="videos-tab" wire:click="updateTab('videos')">Videos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "links") active @endif @if($errors->hasany(['relatedLinks.*'])) error @endif" data-toggle="tab" href="#links" data-tab="links" wire:key="links-tab" wire:click="updateTab('links')">Links</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "downloads") active @endif @if($errors->hasany(['relatedDownloads.*'])) error @endif" data-toggle="tab" href="#downloads" data-tab="downloads" wire:key="downloads-tab" wire:click="updateTab('downloads')">Downloads</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "images") active @endif @if($errors->hasany(['relatedImages.*'])) error @endif" data-toggle="tab" href="#images" data-tab="images" wire:key="images-tab" wire:click="updateTab('images')">Images</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "summary") active @endif @if($errors->hasany(['summary', 'summary_heading', 'summary_text'])) error @endif" data-toggle="tab" href="#summary" data-tab="summary" wire:key="summary-tab" wire:click="updateTab('summary')">Summary</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "filter-settings") active @endif" data-toggle="tab" href="#filter" wire:click="updateTab('filter-settings')">Filter settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "keywords") active @endif" data-toggle="tab" href="#keywords" data-tab="keywords" wire:key="keywords-tab" wire:click="updateTab('keywords')">Keywords</a>
        </li>
        @if ( (isGlobalAdmin()) || (isClientAdmin()) || (isClientAdvisor()) )
            <li class="nav-item">
                <a class="nav-link @if ($activeTab == "client-settings") active @endif @if($errors->hasany(['client', 'internal', 'institutions'])) error @endif" data-toggle="tab" href="#client" wire:click="updateTab('client-settings')">Client settings</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "event-preview") active @endif" data-toggle="tab" href="#client" wire:click="updateTab('event-preview')">Preview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "summary_preview") active @endif" data-toggle="tab" href="#summary_preview" data-tab="summary_preview" wire:key="summary_preview-tab" wire:click="updateTab('summary_preview')">Summary Preview</a>
        </li>

    </ul>


    <!-- Tab panes -->
    <div class="tab-content">

        @include('livewire.admin.includes.events.event-details')

        @include('livewire.admin.includes.events.banner-image')

        @include('livewire.admin.includes.events.event-content')

        @include('livewire.admin.includes.events.videos')

        @include('livewire.admin.includes.events.links')

        @include('livewire.admin.includes.events.downloads')

        @include('livewire.admin.includes.events.images')

        @include('livewire.admin.includes.events.summary')

        @include('livewire.admin.includes.events.filter-settings')

        @include('livewire.admin.includes.events.keywords')

        @if ( (isGlobalAdmin()) || (isClientAdmin()) || (isClientAdvisor()) )
            @include('livewire.admin.includes.events.client-institution-checkbox')
        @endif

        @include('livewire.admin.includes.events.preview')

        @include('livewire.admin.includes.events.summary_preview')

    </div>

    @include('livewire.admin.includes.events.submit')

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.events.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>

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



    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat: "dd/mm/yy"
        });
    } );




    tinymce.init({
        selector: 'textarea.tiny_desc',
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
                //console.log(focusedElement.getAttribute('data-tab'));
                if (focusedElement.getAttribute('data-tab')){
                    @this.set('activeTab', focusedElement.getAttribute('data-tab'));
                }

                @this.set('description', tinymce.get("description").getContent());
            });
        }
    });

</script>
@endpush
