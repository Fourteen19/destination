<div id="alternate" class="tab-pane px-0 @if ($activeTab == "alternate") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">
        <div class="rounded p-4 form-outer">

        <div class="form-group">
            @error('alt_block_heading') <span class="text-danger error">{{ $message }}</span>@enderror
            {!! Form::label('alt_block_heading', 'Alternate text block heading'); !!}
            {!! Form::text('alt_block_heading', (!isset($content->contentable->alt_block_heading)) ? null : $content->contentable->alt_block_heading, array('placeholder' => 'Alternate text block heading','class' => 'form-control', 'maxlength' => 255, 'wire:model.lazy' => 'alt_block_heading')) !!}
        </div>



        <div class="form-group">
            @error('alt_block_text') <span class="text-danger error">{{ $message }}</span>@enderror
            <div  wire:ignore>
            {!! Form::label('alt_block_text', 'Alternate text block content'); !!}
            {!! Form::textarea('alt_block_text', (!isset($content->contentable->alt_block_text)) ? null : $content->contentable->alt_block_text, array('placeholder' => 'Alternate text block content','class' => 'form-control tiny_alt_block_text', 'maxlength' => 999, 'wire:model.lazy' => 'alt_block_text')) !!}
            </div>
        </div>


        <div wire:ignore>
            <div class="form-group">
                @error('lower_body') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('lower_body', 'Lower body text') !!}
                {!! Form::textarea('lower_body', (!isset($content->contentable->lower_body)) ? null : $content->contentable->lower_body, array('placeholder' => 'Body','class' => 'form-control tiny_lower_body', 'maxlength' => 999, 'wire:model.lazy' => 'lower_body')) !!}
            </div>
        </div>
        </div>

        </div>
    </div>
</div>
