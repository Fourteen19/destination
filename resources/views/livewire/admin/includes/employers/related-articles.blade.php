<div id="related-articles" class="tab-pane px-0 @if ($activeTab == "related-articles") active @else fade @endif" wire:key="related-articles-pane">
    <div class="row">
        <div class="col-lg-6">

            {{-- Feature Article--}}
            <div class="rounded p-4 form-outer" x-data="{ relatedArticleSlot1IsVisible: @entangle('relatedArticleSlot1IsVisible')}">
                <div class="form-group">

                    @livewire('admin.article-selector', ['label' => 'Employer article',
                                                'articleUuid' => $relatedArticleSlot1,
                                                'name' => 'relatedArticleSlot1',
                                                'includeClientArticles' => True,
                                                'key' => "related-article-1"])
                </div>
            </div>

        </div>
    </div>
</div>
