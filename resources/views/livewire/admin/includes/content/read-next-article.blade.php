<div id="read_next_article" class="tab-pane px-0 @if ($activeTab == "read_next_article") active @else fade @endif" wire:key="read-next-article-pane">
    <div class="row">
        <div class="col-lg-6">
            <div class="rounded p-4 form-outer">
                <div class="form-group">

                    @livewire('admin.article-selector', ['label' => 'Select the next article to be read', 'articleUuid' => $read_next_article, 'name' => 'read_next_article', 'includeClientArticles' => True, 'key' => "read_next_article"])

                </div>
            </div>
        </div>
    </div>
</div>
