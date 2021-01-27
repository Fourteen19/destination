<div id="summary" class="tab-pane px-0 @if ($activeTab == "summary") active @else fade @endif">
    <div class="row">
        <div class="col-lg-6">
        <div class="rounded p-4 form-outer" x-data="{ summaryImageIsVisible: @entangle('summaryImageIsVisible') }">
            <div class="form-group">
                {!! Form::label('summary_image_type', 'Summary Image'); !!}
                <div class="form-check">
                    {{ Form::radio('summary_image_type', 'Automatic', ($summary_image_type == 'Automatic') ? true : false, ['name' => "summary_image_type", 'id' => "summary_image_type[Automatic]", 'value' => 'Automatic', 'wire:model.lazy' => 'summary_image_type', "@click"=>"summaryImageIsVisible = false"] )}}
                    <label class="form-check-label" for="summary_image_type[Automatic]">Automatic</label>
                </div>
                <div class="form-check">
                    {{ Form::radio('summary_image_type', 'Custom', ($summary_image_type == 'Custom') ? true : false, ['name' => "summary_image_type", 'id' => "summary_image_type[Custom]", 'value' => 'Custom', 'wire:model.lazy' => 'summary_image_type', "@click"=>"summaryImageIsVisible = true"] )}}
                    <label class="form-check-label" for="summary_image_type[Custom]">Custom</label>
                </div>
            </div>

            <div class="form-group" x-show="summaryImageIsVisible">
                @error('summary') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('summary', 'Summary Image'); !!}
                <div class="input-group">
                {!! Form::text('summary', null, array('placeholder' => 'Summary Image','class' => 'form-control', 'maxlength' => 255, 'id' => "summary_image", 'wire:model.lazy' => 'summary' )) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-image-summary">Select</button>
                </div>
                </div>
                <div class="article-image-preview">
                    <img src="{{ $summaryOriginal }}">
                </div>
            </div>



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
</div>
