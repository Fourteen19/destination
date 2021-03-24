<div id="free" class="tab-pane @if ($activeTab == "free-articles") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group">
                {!! Form::label('free_heading', 'Free articles block heading'); !!}
                {!! Form::text('free_heading', $bannerTitle, array('placeholder' => 'Free articles block heading', 'class' => 'form-control', 'maxlength' => 255, 'wire:model.defer' => 'freeArticlesBlockHeading')) !!}
                @error('link1Text') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                {!! Form::label('free_intro', 'Free articles introduction'); !!}
                {!! Form::textarea('free_intro', $bannerTitle, array('placeholder' => 'Free articles block introduction', 'class' => 'form-control', 'cols' => 40, 'rows' => 5, 'wire:model.defer' => 'freeArticlesBlockText')) !!}
                @error('link1Text') <div class="text-danger error">{{ $message }}</div>@enderror
            </div>

            @livewire('admin.article-selector', ['label' => 'Free article - slot 1',
                                                'articleUuid' => $freeArticlesSlot1Page,
                                                'name' => 'freeArticlesSlot1Page',
                                                'includeClientArticles' => True,
                                                'key' => "free-article-1"])

            @livewire('admin.article-selector', ['label' => 'Free article - slot 2',
                                                'articleUuid' => $freeArticlesSlot2Page,
                                                'name' => 'freeArticlesSlot2Page',
                                                'includeClientArticles' => True,
                                                'key' => "free-article-2"])

            @livewire('admin.article-selector', ['label' => 'Free article - slot 3',
                                                'articleUuid' => $freeArticlesSlot3Page,
                                                'name' => 'freeArticlesSlot3Page',
                                                'includeClientArticles' => True,
                                                'key' => "free-article-3"])


        </div>
    </div>
</div>
