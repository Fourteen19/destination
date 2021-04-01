<div id="year13" class="tab-pane px-0 @if ($activeTab == "year13") active @else fade @endif" wire:key="year13-pane">
    <div class="row">
        <div class="col-lg-6">

            {{-- slot 1 --}}
            <div class="rounded p-4 form-outer" x-data="{ year13Slot1IsVisible: @entangle('year13Slot1IsVisible')}">
                <div class="form-group">
                    {!! Form::label('year13_slot1_type', 'Slot 1 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year13_slot1_type', 'managed',  ($year13_slot1_type == 'managed') ? true : false, ['name' => "year13_slot1_type", 'id' => "year13_slot1_type[managed]", 'value' => 'managed', 'wire:model.lazy' => 'year13_slot1_type', "@click"=>"year13Slot1IsVisible = true"] )}}
                        <label class="form-check-label" for="year13_slot1_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year13_slot1_type', 'algorithmic', ($year13_slot1_type == 'algorithmic') ? true : false, ['name' => "year13_slot1_type", 'id' => "year13_slot1_type[algorithmic]", 'value' => 'algorithmic', 'wire:model.lazy' => 'year13_slot1_type', "@click"=>"year13Slot1IsVisible = false"] )}}
                        <label class="form-check-label" for="year13_slot1_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year13Slot1IsVisible">
                    @livewire('admin.homepage-article-selector', ['label' => 'Select article', 'articleUuid' => $year13_slot1_article, 'name' => 'year13_slot1_article', 'includeClientArticles' => True, 'key' => "year13_slot1_article"])
                </div>
            </div>


            {{-- slot 2 --}}
            <div class="rounded p-4 form-outer" x-data="{ year13Slot2IsVisible: @entangle('year13Slot2IsVisible')}">
                <div class="form-group">
                    {!! Form::label('year13_slot2_type', 'Slot 2 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year13_slot2_type', 'managed', ($year13_slot2_type == 'managed') ? true : false, ['name' => "year13_slot2_type", 'id' => "year13_slot2_type[managed]", 'value' => 'managed', 'wire:model.lazy' => 'year13_slot2_type', "@click"=>"year13Slot2IsVisible = true"] )}}
                        <label class="form-check-label" for="year13_slot2_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year13_slot2_type', 'algorithmic', ($year13_slot2_type == 'algorithmic') ? true : false, ['name' => "year13_slot2_type", 'id' => "year13_slot2_type[algorithmic]", 'value' => 'algorithmic', 'wire:model.lazy' => 'year13_slot2_type', "@click"=>"year13Slot2IsVisible = false"] )}}
                        <label class="form-check-label" for="year13_slot2_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year13Slot2IsVisible">
                    @livewire('admin.homepage-article-selector', ['label' => 'Select article', 'articleUuid' => $year13_slot2_article, 'name' => 'year13_slot2_article', 'includeClientArticles' => True, 'key' => "year13_slot2_article"])
                </div>
            </div>


            {{-- slot 3 --}}
            <div class="rounded p-4 form-outer" x-data="{ year13Slot3IsVisible: @entangle('year13Slot3IsVisible')}">
                <div class="form-group">
                    {!! Form::label('year13_slot3_type', 'Slot 3 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year13_slot3_type', 'managed', ($year13_slot3_type == 'managed') ? true : false, ['name' => "year13_slot3_type", 'id' => "year13_slot3_type[managed]", 'value' => 'managed', 'wire:model.lazy' => 'year13_slot3_type', "@click"=>"year13Slot3IsVisible = true"] )}}
                        <label class="form-check-label" for="year13_slot3_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year13_slot3_type', 'algorithmic', ($year13_slot3_type == 'algorithmic') ? true : false, ['name' => "year13_slot3_type", 'id' => "year13_slot3_type[algorithmic]", 'value' => 'algorithmic', 'wire:model.lazy' => 'year13_slot3_type', "@click"=>"year13Slot3IsVisible = false"] )}}
                        <label class="form-check-label" for="year13_slot3_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year13Slot3IsVisible">
                    @livewire('admin.homepage-article-selector', ['label' => 'Select article', 'articleUuid' => $year13_slot3_article, 'name' => 'year13_slot3_article', 'includeClientArticles' => True, 'key' => "year13_slot3_article"])
                </div>
            </div>



            {{-- slot 4--}}
            <div class="rounded p-4 form-outer" x-data="{ year13Slot4IsVisible: @entangle('year13Slot4IsVisible')}">
                <div class="form-group">
                    {!! Form::label('year13_slot4_type', 'Slot 4 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year13_slot4_type', 'managed', ($year13_slot4_type == 'managed') ? true : false, ['name' => "year13_slot4_type", 'id' => "year13_slot4_type[managed]", 'value' => 'managed', 'wire:model.lazy' => 'year13_slot4_type', "@click"=>"year13Slot4IsVisible = true"] )}}
                        <label class="form-check-label" for="year13_slot4_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year13_slot4_type', 'algorithmic', ($year13_slot4_type == 'algorithmic') ? true : false, ['name' => "year13_slot4_type", 'id' => "year13_slot4_type[algorithmic]", 'value' => 'algorithmic', 'wire:model.lazy' => 'year13_slot4_type', "@click"=>"year13Slot4IsVisible = false"] )}}
                        <label class="form-check-label" for="year13_slot4_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year13Slot4IsVisible">
                    @livewire('admin.homepage-article-selector', ['label' => 'Select article', 'articleUuid' => $year13_slot4_article, 'name' => 'year13_slot4_article', 'includeClientArticles' => True, 'key' => "year13_slot4_article"])
                </div>
            </div>


            {{-- slot 5--}}
            <div class="rounded p-4 form-outer" x-data="{ year13Slot5IsVisible: @entangle('year13Slot5IsVisible')}">
                <div class="form-group">
                    {!! Form::label('year13_slot5_type', 'Slot 5 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year13_slot5_type', 'managed', ($year13_slot5_type == 'managed') ? true : false, ['name' => "year13_slot5_type", 'id' => "year13_slot5_type[managed]", 'value' => 'managed', 'wire:model.lazy' => 'year13_slot5_type', "@click"=>"year13Slot5IsVisible = true"] )}}
                        <label class="form-check-label" for="year13_slot5_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year13_slot5_type', 'algorithmic', ($year13_slot5_type == 'algorithmic') ? true : false, ['name' => "year13_slot5_type", 'id' => "year13_slot5_type[algorithmic]", 'value' => 'algorithmic', 'wire:model.lazy' => 'year13_slot5_type', "@click"=>"year13Slot5IsVisible = false"] )}}
                        <label class="form-check-label" for="year13_slot5_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year13Slot5IsVisible">
                    @livewire('admin.homepage-article-selector', ['label' => 'Select article', 'articleUuid' => $year13_slot5_article, 'name' => 'year13_slot5_article', 'includeClientArticles' => True, 'key' => "year13_slot5_article"])
                </div>
            </div>



            {{-- slot 6--}}
            <div class="rounded p-4 form-outer" x-data="{ year13Slot6IsVisible: @entangle('year13Slot6IsVisible')}">
                <div class="form-group">
                    {!! Form::label('year13_slot6_type', 'Slot 6 Type'); !!}
                    <div class="form-check">
                        {{ Form::radio('year13_slot6_type', 'managed', ($year13_slot6_type == 'managed') ? true : false, ['name' => "year13_slot6_type", 'id' => "year13_slot6_type[managed]", 'value' => 'managed', 'wire:model.lazy' => 'year13_slot6_type', "@click"=>"year13Slot6IsVisible = true"] )}}
                        <label class="form-check-label" for="year13_slot6_type[managed]">Managed</label>
                    </div>
                    <div class="form-check">
                        {{ Form::radio('year13_slot6_type', 'algorithmic', ($year13_slot6_type == 'algorithmic') ? true : false, ['name' => "year13_slot6_type", 'id' => "year13_slot6_type[algorithmic]", 'value' => 'algorithmic', 'wire:model.lazy' => 'year13_slot6_type', "@click"=>"year13Slot6IsVisible = false"] )}}
                        <label class="form-check-label" for="year13_slot6_type[algorithmic]">Algorithmic</label>
                    </div>
                </div>

                <div class="form-group" x-show="year13Slot6IsVisible">
                    @livewire('admin.homepage-article-selector', ['label' => 'Select article', 'articleUuid' => $year13_slot6_article, 'name' => 'year13_slot6_article', 'includeClientArticles' => True, 'key' => "year13_slot6_article"])
                </div>
            </div>


            {{-- Feature Article--}}
            <div class="rounded p-4 form-outer" x-data="{ year13FeatureArticleSlot1IsVisible: @entangle('year13FeatureArticleSlot1IsVisible')}">
                <div class="form-group">

                    @livewire('admin.article-selector', ['label' => 'Feature article',
                                                'articleUuid' => $year13FeatureArticleSlot1,
                                                'name' => 'year13FeatureArticleSlot1',
                                                'includeClientArticles' => True,
                                                'key' => "year13-feature-article-1"])
                </div>
            </div>

        </div>
    </div>
</div>
