<div id="article-settings" class="tab-pane px-0 @if ($activeTab == "article-settings") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">
            <div class="rounded p-4 form-outer">
                <div class="form-group">
                    {!! Form::label('title', 'Article Title'); !!}
                    {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control', 'maxlength' => 255, 'wire:model.lazy' => 'title')) !!}
                    @error('title') <div class="text-danger error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    {!! Form::label('slug', 'URL'); !!}
                    {{ $this->baseUrl }}{!! Form::text('slug', null, array('placeholder' => 'slug','class' => 'form-control', 'maxlength' => 255, 'id' => 'slug', 'wire:model.lazy' => 'slug')) !!}
                    @error('slug') <div class="text-danger error">{{ $message }}</div>@enderror
                </div>

                {{-- <div class="form-group">
                    {!! Form::label('type', 'Type'); !!}
                    {!! Form::select('type', ['Article' => 'Article', 'Employer Profile' => 'Employer Profile'], (!isset($content->contentable->type)) ? 'Article' : $content->contentable->type, array('class' => 'form-control', 'wire:model.lazy' => 'type')) !!}
                    @error('type') <div class="text-danger error">{{ $message }}</div>@enderror
                </div> --}}
            </div>
        </div>
    </div>
</div>
