<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('title', 'Title'); !!}
            {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control', 'maxlength' => 255, 'wire:model.lazy' => 'title')) !!}
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
        <div class="form-group @error('lead') has-error @enderror">
            @error('lead') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('lead', 'Lead Paragraph'); !!}
            {!! Form::text('lead', (!isset($content->contentable->lead)) ? null : $content->contentable->lead, array('placeholder' => 'Lead Paragraph','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.lazy'
            => 'lead')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12" wire:ignore>
        <div class="form-group">
            @error('body') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('body', 'Body'); !!}
            {!! Form::textarea('body', (!isset($content->contentable->body)) ? null : $content->contentable->body, array('placeholder' => 'Body','class' => 'form-control tiny', 'maxlength' => 999, 'wire:model.lazy' => 'body')) !!}
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
            @error('statement') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('statement', 'Statement / Fact / Pull out'); !!}
            {!! Form::text('statement', (!isset($content->contentable->statement)) ? null : $content->contentable->statement, array('placeholder' => 'Statement','class' => 'form-control', 'maxlength' => 255, 'wire:model.lazy' => 'statement')) !!}
        </div>
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
                <label>{!! Form::checkbox('tagsYearGroups[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-control', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentYearGroupsTags' ]) !!} {{$tag['name'][app()->getLocale()]}} </label>
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
                <label>{!! Form::checkbox('tagsSubjects[]', $tag['name'][app()->getLocale()], false, ['class' => 'form-control', 'id' => $tag['name'][app()->getLocale()], 'wire:model.lazy' => 'contentSubjectTags' ]) !!} {{$tag['name'][app()->getLocale()]}} </label>
            @endforeach

        </div>
    </div>



    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="button" wire:click.prevent="store()" class="btn btn-primary">Submit</button>
    </div>


    <div id="preview">
        <div>title: {{ $title }}</div>
        <div>lead paragraph: {{ $lead }}</div>
        <div>Body: {!! $body !!}</div>
        <div>Alternate text block content: {!! $alt_block_text !!}</div>
        <div>Links</div>
        @foreach($relatedLinks as $key => $relatedLink)
            <div>{{$relatedLink['title']}}</div>
            <div>{{$relatedLink['url']}}</div>
        @endforeach

    </div>


</div>

@push('scripts')
<script>
    tinymce.init({
    selector: 'textarea.tiny_alt_block_text',
    setup: function(editor) {
        editor.on('blur', function(e) {
            @this.set('alt_block_text', tinymce.get("alt_block_text").getContent());
            @this.set('alt_block_text', tinymce.get("alt_block_text").getContent());
        });
    }
    });
</script>
@endpush
