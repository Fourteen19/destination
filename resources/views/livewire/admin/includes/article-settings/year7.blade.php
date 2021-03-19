<div id="year7" class="tab-pane px-0 @if ($activeTab == "year7") active @else fade @endif" wire:key="year7-pane">
    <div class="row">
        <div class="col-lg-6">
        <div class="rounded p-4 form-outer" x-data="{ summaryImageIsVisible: @entangle('summaryImageIsVisible'), activeTab: @entangle('activeTab') }">
            <div class="form-group">
                {!! Form::label('year7_slot1_type', 'Slot 1 Type'); !!}
                <div class="form-check">
                    {{ Form::radio('year7_slot1_type', 'Managed', ($year7_slot1_type == 'managed') ? true : false, ['name' => "year7_slot1_type", 'id' => "year7_slot1_type[managed]", 'value' => 'Automatic', 'wire:model.lazy' => 'year7_slot1_type', "@click"=>"year7Slot1IsVisible = false"] )}}
                    <label class="form-check-label" for="year7_slot1_type[managed]">Managed</label>
                </div>
                <div class="form-check">
                    {{ Form::radio('year7_slot1_type', 'Algorithmic', ($year7_slot1_type == 'algorithmic') ? true : false, ['name' => "year7_slot1_type", 'id' => "year7_slot1_type[algorithmic]", 'value' => 'Custom', 'wire:model.lazy' => 'year7_slot1_type', "@click"=>"year7Slot1IsVisible = true"] )}}
                    <label class="form-check-label" for="year7_slot1_type[algorithmic]">Algorithmic</label>
                </div>
            </div>

            <div class="form-group" x-show="year7Slot1IsVisible">
                @error('year7_slot1_article') <span class="text-danger error">{{ $message }}</span>@enderror
                {!! Form::label('year7_slot1_article', 'Article'); !!}
                <div class="input-group">
                {!! Form::text('year7_slot1_article', null, array('placeholder' => 'Article','class' => 'form-control', 'maxlength' => 255, 'id' => "summary_image", 'wire:model.lazy' => 'summary' )) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-image-summary">Select</button>
                </div>
                </div>
                <div class="article-image-preview">
                    <img src="{{ $summaryOriginal }}">
                </div>
            </div>
