<div id="articles" class="tab-pane px-0 @if ($activeTab == "articles") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">
            <div class="rounded p-4 form-outer">

                <div class="form-group">
                    @error('globalSettings.articles_wordcount_read_per_minute') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('articles_wordcount_read_per_minute', 'Number of words that can be read per minute by a user'); !!}
                    {!! Form::text('articles_wordcount_read_per_minute', NULL, array('placeholder' => 'Number of words','class' => 'form-control', 'maxlength' => 3, 'wire:model.lazy' => 'globalSettings.articles_wordcount_read_per_minute')) !!}
                </div>

            </div>
        </div>
    </div>
</div>
