<div>

    <ul class="nav nav-tabs mydir-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "article-settings") active @endif @if($errors->hasany(['slug', 'title', 'type'])) error @endif" data-toggle="tab" href="#article-settings" wire:click="updateTab('article-settings')">Settings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "banner-image") active @endif @if($errors->hasany(['banner'])) error @endif" data-toggle="tab" href="#banner-image" wire:click="updateTab('banner-image')">Banner Image</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "main-content") active @endif @if($errors->hasany(['subheading', 'lead', 'body'])) error @endif" data-toggle="tab" href="#main-content" wire:click="updateTab('main-content')">Main Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "videos") active @endif @if($errors->hasany(['relatedVideos.*'])) error @endif" data-toggle="tab" href="#videos" wire:click="updateTab('videos')">Videos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab == "alternate") active @endif @if($errors->hasany(['alt_block_heading', 'alt_block_text'])) error @endif" data-toggle="tab" href="#alternate" wire:click="updateTab('alternate')">Alternate Text</a>
          </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "links") active @endif @if($errors->hasany(['relatedLinks.*'])) error @endif" data-toggle="tab" href="#links" wire:click="updateTab('links')">Links</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "downloads") active @endif @if($errors->hasany(['relatedDownloads.*'])) error @endif" data-toggle="tab" href="#downloads" wire:click="updateTab('downloads')">Downloads</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "summary") active @endif @if($errors->hasany(['summary_heading', 'summary_text'])) error @endif" data-toggle="tab" href="#summary" wire:click="updateTab('summary')">Summary</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "filters") active @endif" data-toggle="tab" href="#filters" wire:click="updateTab('filters')">Filters</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if ($activeTab == "previews") active @endif" data-toggle="tab" href="#previews" wire:click="updateTab('previews')">Preview</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">


        @include('livewire.admin.includes.content.article-settings')

        @include('livewire.admin.includes.content.main-content')

        @include('livewire.admin.includes.content.banner-image')

        @include('livewire.admin.includes.content.alternate')

        @include('livewire.admin.includes.content.videos')

        @include('livewire.admin.includes.content.links')

        @include('livewire.admin.includes.content.downloads')

        @include('livewire.admin.includes.content.summary')

        @include('livewire.admin.includes.content.filters')



        <div id="previews" class="tab-pane @if ($activeTab == "previews") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                    <div id="preview">

                        <div>summary slot 1: <img src="{{$summaryImageSlot1Preview}}"></div>
                        <div>summary slot 2-3: <img src="{{$summaryImageSlot23Preview}}"></div>
                        <div>summary slot 4-5-6: <img src="{{$summaryImageSlot456Preview}}"></div>
                        <div>summary You might like: <img src="{{$summaryImageYouMightLikePreview}}"></div>


                        <div>banner: <img src="{{$bannerImagePreview}}"></div>
                        <div>title: {{ $title }}</div>
                        <div>subheading: {{ $subheading }}</div>
                        <div>lead paragraph: {{ $lead }}</div>
                        <div>Body: {!! $body !!}</div>
                        <div>Alternate text block heading: {!! $alt_block_heading !!}</div>
                        <div>Alternate text block content: {!! $alt_block_text !!}</div>
                        <div>Body: {!! $lower_body !!}</div>

                        <div>videos</div>
                        @foreach($relatedVideos as $key => $item)
                            <div>{{$item['url']}}</div>
                        @endforeach

                        <div>Links</div>
                        @foreach($relatedLinks as $key => $item)
                            <div>{{$item['title']}}</div>
                            <div>{{$item['url']}}</div>
                        @endforeach

                        <div>Downloads</div>
                        @foreach($relatedDownloads as $key => $item)
                            <div>{{$item['title']}}</div>
                            <div>{{$item['url']}}</div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>

    </div>

    @include('livewire.admin.includes.content.submit')


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
            console.log('banner');
            livewire.emit('make_banner_image', $url);
        } else if (inputId == 'summary_image'){
            console.log('summary');
            livewire.emit('make_summary_image', $url);
        } else {

        }

    }

    /***************/



    tinymce.init({
        selector: 'textarea.tiny_alt_block_text',
        plugins: [
            'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media image nonbreaking',
            'save table directionality emoticons template paste'
        ],
        relative_urls: true,
        document_base_url: '{{ Config::get('app.url') }}',//'http://ck.platformbrand.com:8000',
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
                @this.set('alt_block_text', tinymce.get("alt_block_text").getContent());
            });
        }
    });


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


    tinymce.init({
        selector: 'textarea.tiny_lower_body',
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
                @this.set('lower_body', tinymce.get("lower_body").getContent());
            });
        }
    });

</script>
@endpush
