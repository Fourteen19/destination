<div id="year7" class="tab-pane px-0 @if ($activeTab == "year7") active @else fade @endif" wire:key="year7-pane">
    <div class="row">
        <div class="col-lg-6">
            <div class="rounded p-4 form-outer" x-data="{ year7Slot1IsVisible: @entangle('year7Slot1IsVisible'), activeTab: @entangle('activeTab') }">
                <div class="form-group">
                    {!! Form::label('year7_slot1_type', 'Slot 1 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year7_slot1_type', 'Managed', ($year7_slot1_type == 'managed') ? true : false, ['name' => "year7_slot1_type", 'id' => "year7_slot1_type[managed]", 'value' => 'Automatic', 'wire:model.lazy' => 'year7_slot1_type', "@click"=>"year7Slot1IsVisible = true"] )}}
                        <label class="form-check-label" for="year7_slot1_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year7_slot1_type', 'Algorithmic', ($year7_slot1_type == 'algorithmic') ? true : false, ['name' => "year7_slot1_type", 'id' => "year7_slot1_type[algorithmic]", 'value' => 'Custom', 'wire:model.lazy' => 'year7_slot1_type', "@click"=>"year7Slot1IsVisible = false"] )}}
                        <label class="form-check-label" for="year7_slot1_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year7Slot1IsVisible">
                    @error('year7_slot1_article') <span class="text-danger error">{{ $message }}</span>@enderror
                    @livewire('admin.article-selector', ['label' => 'Select article', 'articleUuid' => NULL, 'name' => 'year7_slot1_article', 'includeClientArticles' => True, 'key' => "year7_slot1_article"])
                </div>
            </div>


            <div class="rounded p-4 form-outer" x-data="{ year7Slot2IsVisible: @entangle('year7Slot2IsVisible'), activeTab: @entangle('activeTab') }">
                <div class="form-group">
                    {!! Form::label('year7_slot2_type', 'Slot 2 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year7_slot2_type', 'Managed', ($year7_slot2_type == 'managed') ? true : false, ['name' => "year7_slot2_type", 'id' => "year7_slot2_type[managed]", 'value' => 'Automatic', 'wire:model.lazy' => 'year7_slot2_type', "@click"=>"year7Slot2IsVisible = true"] )}}
                        <label class="form-check-label" for="year7_slot2_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year7_slot2_type', 'Algorithmic', ($year7_slot2_type == 'algorithmic') ? true : false, ['name' => "year7_slot2_type", 'id' => "year7_slot2_type[algorithmic]", 'value' => 'Custom', 'wire:model.lazy' => 'year7_slot2_type', "@click"=>"year7Slot2IsVisible = false"] )}}
                        <label class="form-check-label" for="year7_slot2_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year7Slot2IsVisible">
                    @error('year7_slot2_article') <span class="text-danger error">{{ $message }}</span>@enderror
                    {!! Form::label('year7_slot2_article', 'Article'); !!}
                    @livewire('admin.article-selector', ['label' => 'Select article', 'articleUuid' => NULL, 'name' => 'year7_slot2_article', 'includeClientArticles' => True, 'key' => "year7_slot2_article"])
                </div>
            </div>


        </div>
    </div>
</div>
