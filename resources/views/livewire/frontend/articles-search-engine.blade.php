<div>
    <div class="row justify-content-center my-5">
        <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
            <div class="pt-4">
                <h1 class="fw700 t36 mb-4">Find an article</h1>
                @if ($searchedTerm != '')
                    <p class="fw700 t20 mb-4">You searched for “{{$searchedTerm}}”.</p>
                    <p class="fw700 t20">
                    @if ($nbArticlesFound == 0)
                        We have not found any articles matching your search
                    @else
                        We have found {{$nbArticlesFound}} articles matching your search
                    @endif
                    </p>
                @endif
            </div>
        </div>
        <div class="col-xl-5 col-lg-6">
            <div class="search-container def-border pl-lg-4 pt-lg-4 pb-lg-4" x-data="{ isVisible: @entangle('isVisible') }">
                <h2 class="t24 fw700">Search for something else</h2>

                <form class="form-inline align-items-center position-relative" wire:submit.prevent="filterArticlesWithString" @click.away="isVisible = false">
                    <div class="form-group col-8 p-0 mr-3 mb-0">
                        <label for="searcharticles" class="sr-only">Search for something else</label>
                        <input type="field"
                            class="form-control search-form"
                            x-refs="search"
                            id="searcharticles"
                            placeholder="Enter keywords"
                            wire:model.debounce="search"
                            @focus="isVisible = true"
                            @keydown.escape.window="isVisible = false"
                            @keydown.enter.window="isVisible = false;"
                            @keydown="isVisible = true"
                            @keydown.shift.tab="isVisible = false"
                            autocomplete="off"
                            >
                    </div>
                     <button type="submit" class="platform-button border-0 t-def">Search</button>


                    @if (strlen($search) > 0)

                        {{-- @if (count($searchKeywordsResults) > 0) --}}
                        <div class="suggestions position-absolute" style="display:none" x-show="isVisible">

                        <h4 class="suggestion-title">Suggestions</h4>
                        <div wire:loading wire:target="search" x-show.transition.opcatity.duration.1000ms="isVisible" class="searching">Searching</div>
                            <ul class="suggestion-results list-unstyled mb-0">
                                @foreach($searchKeywordsResults as $keyword)
                                    {{-- <li @click.prevent="isVisible = false" wire:click.prevent="filterArticlesWithKeyword('{{$keyword['name']}}')"><a href="#" class="td-no keyword-link">{{$keyword['name']}}</a></li> --}}
                                    <li wire.key="keyword_{{$loop->index}}" @click.prevent="isVisible = false" wire:click.prevent="filterArticlesWithKeyword('{{$keyword['name']}}')"><a href="#" class="td-no keyword-link">{{$keyword['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        {{-- @else

                        @endif --}}
                    @endif

                </form>
            </div>
        </div>
    </div>

    @if ($articles)
        <div class="row">
            @foreach($articles as $article)

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
            {{ $articles->links('livewire.frontend.search-pagination', ['clientSubdomain' => session('fe_client.subdomain')] ) }}
            </div>
        </div>

    @endif

</div>
