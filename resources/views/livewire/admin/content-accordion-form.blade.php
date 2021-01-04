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
            <a class="nav-link @if ($activeTab == "questions") active @endif @if($errors->hasany(['relatedQuestions.*'])) error @endif" data-toggle="tab" href="#questions" wire:click="updateTab('questions')">Questions</a>
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

        <div id="article-settings" class="tab-pane @if ($activeTab == "article-settings") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                    <div class="form-group">
                        @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                        {!! Form::label('title', 'Title'); !!}
                        {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control', 'maxlength' => 255, 'wire:model' => 'title')) !!}
                    </div>

                    <div class="form-group">
                        @error('slug') <span class="text-danger error">{{ $message }}</span>@enderror
                        {!! Form::label('slug', 'URL'); !!}
                        {{ $this->baseUrl }}{!! Form::text('slug', null, array('placeholder' => 'slug','class' => 'form-control', 'maxlength' => 255, 'id' => 'slug', 'wire:model' => 'slug')) !!}
                    </div>

                    <div class="form-group">
                        @error('type') <span class="text-danger error">{{ $message }}</span>@enderror
                        {!! Form::label('type', 'Type'); !!}
                        {!! Form::select('type', ['Article' => 'Article', 'Employer Profile' => 'Employer Profile'], (!isset($content->contentable->type)) ? 'Article' : $content->contentable->type, array('class' => 'form-control', 'wire:model.lazy' => 'type')) !!}
                    </div>

                </div>
            </div>
        </div>


        <div id="main-content" class="tab-pane @if ($activeTab == "main-content") active @else fade @endif">
            <div class="row">
                <div class="col-lg-8">

                <div class="form-group @error('subheading') has-error @enderror">
                    @error('subheading') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('subheading', 'Subheading'); !!}
                    {!! Form::text('subheading', (!isset($content->contentable->subheading)) ? null : $content->contentable->subheading, array('placeholder' => 'Subheading','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.lazy'
                    => 'subheading')) !!}
                </div>

                <div class="form-group @error('lead') has-error @enderror">
                    @error('lead') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('lead', 'Lead Paragraph'); !!}
                    {!! Form::textarea('lead', (!isset($content->contentable->lead)) ? null : $content->contentable->lead, array('placeholder' => 'Lead Paragraph','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.lazy'
                    => 'lead')) !!}
                </div>

                <div wire:ignore>
                    <div class="form-group">
                    @error('body') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('body', 'Body'); !!}
                    {!! Form::textarea('body', (!isset($content->contentable->body)) ? null : $content->contentable->body, array('placeholder' => 'Body','class' => 'form-control tiny_body', 'maxlength' => 999, 'wire:model.lazy' => 'body')) !!}
                    </div>
                </div>

                </div>
            </div>
        </div>

        <div id="banner-image" class="tab-pane @if ($activeTab == "banner-image") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                <div class="form-group">
                    {!! Form::label('banner', 'Banner Image'); !!}
                    {!! Form::text('banner', null, array('placeholder' => 'Title','class' => 'form-control', 'maxlength' => 255, 'id' => "banner_image", 'wire:model' => 'banner' )) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
                    </div>
                    <div id="banner_image_preview">
                        <img src="{{ $banner_image_preview }}">
                    </div>
                </div>

                </div>
            </div>
        </div>


        <div id="questions" class="tab-pane @if ($activeTab == "questions") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                    @foreach($relatedQuestions as $key => $relatedQuestion)

                        <div class="form-group" >
                            
                            <div wire:ignore>
                                <span>Question {{ $key }}</span>  
                                {!! Form::textarea('relatedQuestions['.$key.'][title]', '', array('placeholder' => 'Question','class' => 'form-control tiny_question_title', 'wire:model.lazy' => 'relatedQuestions.'.$key.'.title', 'id' => 'relatedQuestions['.$key.'][title]' )) !!}
                                @error('relatedQuestions.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror
                            </div>

                            
                            {{--
                <div wire:ignore>
                <textarea class="tiny" 
                        id='relatedQuestions[{{$key}}][title]'
                        name='relatedQuestions[{{$key}}][title]' 
                        rows="20"
                        wire:model = "relatedQuestions.{{$key}}.title"
                        wire:key="relatedQuestions.{{$key}}.title"
                        x-data
                        x-ref="relatedQuestions.{{$key}}.title"
                        x-init="
                        tinymce.init({
                                        selector: '.tiny',
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
                                    });
                        ">
                    </textarea>
                </div>
--}}
                            <br/>
                            <span>Answer {{ $key }}</span>
                            <input type="textarea" class="form-control tiny_question_answer" placeholder="Enter text"  name="relatedQuestions[{{$key}}]['text']" wire:model.lazy="relatedQuestions.{{$key}}.text">
                            @error('relatedQuestions.'.$key.'.text')<span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedQuestion({{ $key }});">remove question {{ $key }}</button>

                    @endforeach

                    <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedQuestion();">Add a question</button>

                </div>
            </div>
        </div>



        <div id="links" class="tab-pane @if ($activeTab == "links") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                    @foreach($relatedLinks as $key => $relatedLink)

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter title"  name="relatedLinks[{{$key}}]['title']" wire:model.lazy="relatedLinks.{{$key}}.title">
                            @error('relatedLinks.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror

                            <input type="text" class="form-control" placeholder="Enter URL"  name="relatedLinks[{{$key}}]['url']" wire:model.lazy="relatedLinks.{{$key}}.url">
                            @error('relatedLinks.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                        </div>

                        <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedLink({{$key}})">remove</button>

                    @endforeach

                    <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedLink()">Add a link</button>

                </div>
            </div>
        </div>

        <div id="downloads" class="tab-pane @if ($activeTab == "downloads") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                @foreach($relatedDownloads as $key => $relatedDownload)

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter title"  name="relatedDownloads[{{$key}}]['title']" wire:model.lazy="relatedDownloads.{{$key}}.title">
                        @error('relatedDownloads.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror

                        <input type="text" class="form-control" placeholder="Enter URL"  name="relatedDownloads[{{$key}}]['url']" wire:model.lazy="relatedDownloads.{{$key}}.url">
                        @error('relatedDownloads.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>

                    <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedDownload({{$key}})">remove</button>

                @endforeach
                <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedDownload()">Add a download</button>



                </div>
            </div>
        </div>

        <div id="summary" class="tab-pane @if ($activeTab == "summary") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                    <div class="form-group">
                        @error('summary_heading') <span class="text-danger error">{{ $message }}</span>@enderror
                        {!! Form::label('summary_heading', 'Summary Heading'); !!}
                        {!! Form::text('summary_heading', null, array('placeholder' => 'Summary Heading','class' => 'form-control', 'maxlength' => 255, 'wire:model' => 'summary_heading')) !!}
                    </div>

                    <div class="form-group">
                        @error('summary_text') <span class="text-danger error">{{ $message }}</span>@enderror
                        {!! Form::label('summary_text', 'Summary Text'); !!}
                        {!! Form::textarea('summary_text', null, array('placeholder' => 'Summary Text','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model' => 'summary_text')) !!}
                    </div>

                </div>
            </div>
        </div>

        <div id="filters" class="tab-pane @if ($activeTab == "filters") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">


                <div class="form-group">
                    {!! Form::label('tagsYearGroups', 'Year Groups'); !!}

                    @foreach($tagsYearGroups as $tag)
                        <div class="form-check">
                        {!! Form::checkbox('tagsYearGroups[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentYearGroupsTags' ]) !!}
                        <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                        {{$tag['name'][app()->getLocale()]}}
                        </label>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="form-group">
                    {!! Form::label('tagsLscs', 'Careers Readiness Score'); !!}

                    @foreach($tagsLscs as $tag)
                        <div class="form-check">
                        {!! Form::checkbox('tagsLscs[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentLscsTags' ]) !!}
                        <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                        {{$tag['name'][app()->getLocale()]}}
                        </label>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="form-group">
                    {!! Form::label('tagsRoutes', 'Routes'); !!}

                    @foreach($tagsRoutes as $tag)
                        <div class="form-check">
                        {!! Form::checkbox('tagsRoutes[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentRoutesTags' ]) !!}
                        <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                        {{$tag['name'][app()->getLocale()]}}
                        </label>
                        </div>
                    @endforeach

                </div>
                <hr>
                <div class="form-group">
                    {!! Form::label('tagsSectors', 'Sectors'); !!}

                    @foreach($tagsSectors as $tag)
                        <div class="form-check">
                        {!! Form::checkbox('tagsSectors[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentSectorsTags' ]) !!}
                        <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                        {{$tag['name'][app()->getLocale()]}}
                        </label>
                        </div>
                    @endforeach

                </div>
                <hr>
                <div class="form-group">
                    {!! Form::label('tagsSubjects', 'Subjects'); !!}

                    @foreach($tagsSubjects as $tag)
                        <div class="form-check">
                        {!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model' => 'contentSubjectTags' ]) !!}
                        <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                        {{$tag['name'][app()->getLocale()]}}
                        </label>
                        </div>
                    @endforeach

                </div>
                <hr>
                <div class="form-group">
                    {!! Form::label('tagsFlags', 'Other Content Flags'); !!}

                    @foreach($tagsFlags as $tag)
                        <div class="form-check">
                        {!! Form::checkbox('tagsFlags[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-check-input', 'id' => $tag['name'][app()->getLocale()], 'wire:model' => 'contentFlagTags' ]) !!}
                        <label class="form-check-label" for="{{$tag['name'][app()->getLocale()]}}">
                        {{$tag['name'][app()->getLocale()]}}
                        </label>
                        </div>
                    @endforeach

                </div>


                </div>
            </div>
        </div>

        <div id="previews" class="tab-pane @if ($activeTab == "previews") active @else fade @endif">
            <div class="row">
                <div class="col-lg-6">

                    <div id="preview">
                        <div><img src="{{ $banner_image_preview }}"></div>
                        <div>title: {{ $title }}</div>
                        <div>subheading: {{ $subheading }}</div>
                        <div>lead paragraph: {{ $lead }}</div>
                        <div>Body: {!! $body !!}</div>
                        <div>Body: {!! $lower_body !!}</div>

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


    <div class="row">


        {{-- $('#slug').attr('readonly', false); --}}

        <button type="button" wire:click.prevent="store()" class="btn mydir-button mr-2">Save @if($action == 'add') and Exit @endif</button>

        <button type="button" wire:click.prevent="storeAndMakeLive()" class="btn mydir-button">Save And Make Live</button>



        @if ($errors->any())
            <div>Error! Please check your article</div>
        @else
            <div>Saved!</div>
        @endif


        @if (Session::has('fail'))
            <div>Your data could not be saved!</div>
        @endif

        @if (Session::has('success'))
            <div>Your data has been saved!</div>
        @endif

    </div>

</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.1.0/dist/livewire-sortable.js"></script>
@endpush


@push('scripts')
<script>

    /****************/

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        absolute_path = $url;
        relative_path = absolute_path.split("storage/ck/").pop();
        //alert(relative_path);
        document.getElementById('banner_image').value = relative_path;
        livewire.emit('make_image', relative_path);
//        document.getElementById('banner_image_preview').prepend('<img src="'+$url+'" />');
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





    window.addEventListener('componentUpdated', event => {
        addTinyMCE();
    });



    // Add TinyMCE
    function addTinyMCE(){
/*
        // Initialize
        tinymce.init({
            selector: '.tiny_question_title',
            themes: 'modern',
            height: 200
        });
*/

        tinymce.init({
            selector: '.tiny_question_title',
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
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('blur', function(e) {
                    myStr = tinymce.activeEditor.id;
                    id = myStr.match(/\d+/);
                    @this.set('relatedQuestions.'+id+'.title', tinymce.get('relatedQuestions['+id+'][title]').getContent());
                });
            }

        });

        
    }

</script>
@endpush