<div>

    <div class="form-check mb-3">
        <input class="form-check-input position-relative mr-2" type="radio" name="orderBy" id="prefered" value="prefered" wire:model="orderBy" wire.key="orderBy">
        <label class="form-check-label t20 fw700" for="prefered">
        Sort by my prefered {{$tagType}}s
        </label>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input position-relative mr-2" type="radio" name="orderBy" id="alpha" value="alpha" wire:model="orderBy" wire.key="orderBy">
        <label class="form-check-label t20 fw700" for="alpha">
            Sort by alphabetically
        </label>
    </div>

    <div wire:loading.delay>
        Loading...
    </div>

    @if ($myTaggedArticles)

        <div class="row">
            @foreach($myTaggedArticles as $article)

                <div class="col-xl-3 col-sm-6 col-lg-4 mb-4">

                    <a href="{{ route('frontend.article', ['clientSubdomain' => session('fe_client.subdomain'), 'article' => (!empty($article->slug)) ? $article->slug : '1' ])}}" class="td-no">
                        <div class="h-100 mlg-bg">
                            <div class="search-img">
                            <img src="{{parse_encode_url($article->getFirstMediaUrl('summary', 'search')) ?? ''}}" onerror="this.style.display='none'">
                            </div>
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <div class="article-summary mlg-bg mbh-1">
                                    <h4 class="fw700 t20">{{ $article->summary_heading }}</h4>
                                    <p class="t16 mb-0">
                                        @if ($article->template_id == 4)
                                            @foreach($article->sectorTags()->get() as $tag)
                                                {{$tag->name}}<br/>
                                            @endforeach
                                        @else
                                            {{ Str::limit($article->summary_text, $limit = 140, $end = '...') }}
                                        @endif
                                    </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            @endforeach
        </div>

        <div class="row">
            <div class="col">
            {{ $myTaggedArticles->links('livewire.frontend.search-pagination', ['clientSubdomain' => session('fe_client.subdomain')] ) }}
            </div>
        </div>

    @endif

</div>
