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
                            wire:model.debounce.1000ms="search"
                            @focus="isVisible = true"
                            @keydown.escape.window="isVisible = false"
                            @keydown.enter.window="isVisible = false;"
                            @keydown="isVisible = true"
                            @keydown.shift.tab="isVisible = false"
                            autocomplete="off"
                            >
                    </div>
                     <button type="submit" class="platform-button border-0 t-def">Search</button>


                    @if (strlen($search) >= 3)

                        @if (count($searchKeywordsResults) > 0)
                        <div class="suggestions position-absolute" style="display:none" x-show="isVisible">

                        <h4 class="suggestion-title">Suggestions</h4>
                        <div wire:loading wire:target="search" x-show.transition.opcatity.duration.1000ms="isVisible" class="searching">Searching</div>
                            <ul class="suggestion-results list-unstyled mb-0">
                                @foreach($searchKeywordsResults as $keyword)
                                    <li @click.prevent="isVisible = false" wire:click.prevent="filterArticlesWithKeyword('{{$keyword['name']}}')"><a href="#" class="td-no keyword-link">{{$keyword['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @else

                        @endif
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
                        <img src="{{ !empty($article->getFirstMediaUrl('summary', 'search')) ? $article->getFirstMediaUrl('summary', 'search') : config('global.default_summary_images.search')}}">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <div class="article-summary mlg-bg mbh-1">
                                <h4 class="fw700 t20">{{ $article->summary_heading }}</h4>
                                <p class="t16 mb-0">{{ Str::limit($article->summary_text, $limit = 140, $end = '...') }}</p>

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


{{--
<div class="row">
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-sm-6 col-lg-4 mb-4">
    <a href="#" class="td-no">
        <img src="https://via.placeholder.com/740x440.png?text=Article+Image">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="article-summary mlg-bg mbh-1">
                <h4 class="fw700 t20">Article title</h4>
                <p class="t16 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                </div>
            </div>
        </div>
    </a>
</div>
</div>

<div class="row align-items-center">
<div class="col-12">
    <div class="w-100 border-top def-border my-4"></div>
</div>
<div class="col-lg-3">
    <p class="t24 fw700 mb-lg-0">Search results 1 - 12 of ###</p>
</div>
<div class="col-lg-6">
    <div class="d-inline-block t24 fw700 mr-2">Page:</div>
    <div class="d-inline-block paginate"><a href="#">1</a></div>
    <div class="d-inline-block paginate"><a href="#">2</a></div>
    <div class="d-inline-block t24 fw700 mr-2">...</div>
    <div class="d-inline-block paginate"><a href="#">N</a></div>
</div>
</div>
--}}
