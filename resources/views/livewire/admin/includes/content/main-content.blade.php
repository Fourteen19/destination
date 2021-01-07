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
