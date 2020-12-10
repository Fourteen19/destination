<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('title', 'Title'); !!}
            {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control', 'maxlength' => 255, 'wire:model' => 'title')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            @error('slug') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('slug', 'URL'); !!}
            {{ $this->baseUrl }}{!! Form::text('slug', null, array('placeholder' => 'slug','class' => 'form-control', 'readonly', 'maxlength' => 255, 'id' => 'slug', 'wire:model' => 'slug')) !!}
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
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


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            @error('type') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('type', 'Type'); !!}
            {!! Form::select('type', ['Article' => 'Article', 'Employer Profile' => 'Employer Profile'], (!isset($content->contentable->type)) ? 'Article' : $content->contentable->type, array('class' => 'form-control', 'wire:model.lazy' => 'type')) !!}
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group @error('subheading') has-error @enderror">
            @error('subheading') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('subheading', 'Subheading'); !!}
            {!! Form::text('subheading', (!isset($content->contentable->subheading)) ? null : $content->contentable->subheading, array('placeholder' => 'Subheading','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.lazy'
            => 'subheading')) !!}
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group @error('lead') has-error @enderror">
            @error('lead') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('lead', 'Lead Paragraph'); !!}
            {!! Form::textarea('lead', (!isset($content->contentable->lead)) ? null : $content->contentable->lead, array('placeholder' => 'Lead Paragraph','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.lazy'
            => 'lead')) !!}
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12" wire:ignore>
        <div class="form-group">
            @error('body') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('body', 'Body'); !!}
            {!! Form::textarea('body', (!isset($content->contentable->body)) ? null : $content->contentable->body, array('placeholder' => 'Body','class' => 'form-control tiny_body', 'maxlength' => 999, 'wire:model.lazy' => 'body')) !!}
        </div>
    </div>


    <div class="container">
        @foreach($videos as $key => $video)
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter video URL"  name="videos[{{$key}}]['url']" wire:model.lazy="videos.{{$key}}.url">
                         @error('videos.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger btn-sm" wire:click.prevent="removeVideo({{$key}})">remove</button>
                </div>
            </div>
        @endforeach
        <button class="btn text-white btn-info btn-sm" wire:click.prevent="addVideo({{$videosIteration}})">Add a video</button>
    </div>



    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            @error('alt_block_heading') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('alt_block_heading', 'Alternate text block heading'); !!}
            {!! Form::text('alt_block_heading', (!isset($content->contentable->alt_block_heading)) ? null : $content->contentable->alt_block_heading, array('placeholder' => 'Alternate text block heading','class' => 'form-control', 'maxlength' => 255, 'wire:model.lazy' => 'alt_block_heading')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            @error('alt_block_text') <span class="text-danger error">{{ $message }}</span>@enderror
            <div  wire:ignore>
            {!! Form::label('alt_block_text', 'Alternate text block content'); !!}
            {!! Form::textarea('alt_block_text', (!isset($content->contentable->alt_block_text)) ? null : $content->contentable->alt_block_text, array('placeholder' => 'Alternate text block content','class' => 'form-control tiny_alt_block_text', 'maxlength' => 999, 'wire:model.lazy' => 'alt_block_text')) !!}
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12" wire:ignore>
        <div class="form-group">
            @error('lower_body') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('lower_body', 'Lower body text') !!}
            {!! Form::textarea('lower_body', (!isset($content->contentable->lower_body)) ? null : $content->contentable->lower_body, array('placeholder' => 'Body','class' => 'form-control tiny_lower_body', 'maxlength' => 999, 'wire:model.lazy' => 'lower_body')) !!}
        </div>
    </div>



    <div class="container">
        @foreach($relatedLinks as $key => $relatedLink)
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter title"  name="relatedLinks[{{$key}}]['title']" wire:model.lazy="relatedLinks.{{$key}}.title">
                        @error('relatedLinks.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror

                        <input type="text" class="form-control" placeholder="Enter URL"  name="relatedLinks[{{$key}}]['url']" wire:model.lazy="relatedLinks.{{$key}}.url">
                        @error('relatedLinks.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedLink({{$key}})">remove</button>
                </div>
            </div>
        @endforeach
        <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedLink({{$relatedLinksIteration}})">Add a link</button>
    </div>



    <div class="container">
        @foreach($relatedDownloads as $key => $relatedDownload)
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter title"  name="relatedDownloads[{{$key}}]['title']" wire:model.lazy="relatedDownloads.{{$key}}.title">
                        @error('relatedDownloads.'.$key.'.title')<span class="text-danger error">{{ $message }}</span>@enderror

                        <input type="text" class="form-control" placeholder="Enter URL"  name="relatedDownloads[{{$key}}]['url']" wire:model.lazy="relatedDownloads.{{$key}}.url">
                        @error('relatedDownloads.'.$key.'.url')<span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger btn-sm" wire:click.prevent="removeRelatedDownload({{$key}})">remove</button>
                </div>
            </div>
        @endforeach
        <button class="btn text-white btn-info btn-sm" wire:click.prevent="addRelatedDownload({{$relatedDownloadsIteration}})">Add a download</button>
    </div>





    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('tagsYearGroups', 'Year Groups Tags'); !!}

            @foreach($tagsYearGroups as $tag)
                <label>{!! Form::checkbox('tagsYearGroups[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-control', 'id' => $tag['name'][app()->getLocale()], 'wire:model' => 'contentYearGroupsTags' ]) !!} {{$tag['name'][app()->getLocale()]}} </label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('tagsLscs', 'Life Stage Careers Score LSCS Tags'); !!}

            @foreach($tagsLscs as $tag)
                <label>{!! Form::checkbox('tagsLscs[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-control', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentLscsTags' ]) !!} {{$tag['name'][app()->getLocale()]}} </label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('tagsRoutes', 'Route Tags'); !!}

            @foreach($tagsRoutes as $tag)
                <label>{!! Form::checkbox('tagsRoutes[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-control', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentRoutesTags' ]) !!} {{$tag['name'][app()->getLocale()]}} </label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('tagsSectors', 'Sector Tags'); !!}

            @foreach($tagsSectors as $tag)
                <label>{!! Form::checkbox('tagsSectors[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-control', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentSectorsTags' ]) !!} {{$tag['name'][app()->getLocale()]}} </label>
            @endforeach

        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('tagsSubjects', 'Subject Tags'); !!}

            @foreach($tagsSubjects as $tag)
                <label>{!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-control', 'id' => $tag['name'][app()->getLocale()], 'wire:model' => 'contentSubjectTags' ]) !!} {{$tag['name'][app()->getLocale()]}} </label>
            @endforeach

        </div>
    </div>


{{-- $('#slug').attr('readonly', false); --}}
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="button" wire:click.prevent="store()" class="btn btn-primary">Save</button>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="button" wire:click.prevent="storeAndMakeLive()" class="btn btn-primary">Save And Make Live</button>
    </div>


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

    <div id="preview">
        <div>title: {{ $title }}</div>
        <div>subheading: {{ $subheading }}</div>
        <div>lead paragraph: {{ $lead }}</div>
        <div>Body: {!! $body !!}</div>
        <div>Alternate text block heading: {!! $alt_block_heading !!}</div>
        <div>Alternate text block content: {!! $alt_block_text !!}</div>
        <div>Body: {!! $lower_body !!}</div>

        <div>videos</div>
        @foreach($videos as $key => $item)
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

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush


@push('scripts')
<script>

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        document.getElementById('banner_image').value = $url;
        document.getElementById('banner_image_preview').prepend('<img src="'+$url+'" />');
    }









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
