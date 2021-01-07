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
