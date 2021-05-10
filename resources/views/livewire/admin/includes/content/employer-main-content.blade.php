<div id="main-content" class="tab-pane px-0 @if ($activeTab == "main-content") active @else fade @endif" wire:key="main-content-pane">
    <div class="row">
        <div class="col-lg-8">
        <div class="rounded p-4 form-outer">

        <div wire:ignore>
            <div class="form-group">
            @error('introduction') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('introduction', 'Introduction'); !!}
            {!! Form::textarea('introduction', (!isset($content->contentable->introduction)) ? null : $content->contentable->introduction, array('placeholder' => 'Introduction','class' => 'form-control tiny_introduction', 'maxlength' => 999, 'wire:model.defer' => 'introduction')) !!}
            </div>
        </div>

        <div class="form-group @error('subheading') has-error @enderror">
            @error('subheading') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('subheading', 'Subheading'); !!}
            {!! Form::text('subheading', (!isset($content->contentable->subheading)) ? null : $content->contentable->subheading, array('placeholder' => 'Subheading','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer'
            => 'subheading')) !!}
        </div>

        <div class="form-group @error('lead') has-error @enderror">
            @error('lead') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('lead', 'Lead Paragraph'); !!}
            {!! Form::textarea('lead', (!isset($content->contentable->lead)) ? null : $content->contentable->lead, array('placeholder' => 'Lead Paragraph','class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer'
            => 'lead')) !!}
        </div>

        <div wire:ignore>
            <div class="form-group">
            @error('body') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('body', 'Body'); !!}
            {!! Form::textarea('body', (!isset($content->contentable->body)) ? null : $content->contentable->body, array('placeholder' => 'Body','class' => 'form-control tiny_body', 'maxlength' => 999, 'wire:model.defer' => 'body')) !!}
            </div>
        </div>

        </div>
        </div>
    </div>
</div>