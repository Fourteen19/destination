<div id="preview" class="tab-pane @if ($activeTab == "preview") active @else fade @endif">
    <div class="row">
        <div class="col-lg-8">


        <img src="{{ $bannerImagePreview }}">

        {{ $bannerTitle }}

        {{ $bannerText }}

        {{-- if the button text and link have been set --}}
        @if ( (!empty($bannerLink1Text)) && (!empty($previewBannerButtons[0])) )
            <a href="/{{$previewBannerButtons[0]['slug']}}">{{ $bannerLink1Text }}</a>
        @endif

        {{-- if the button text and link have been set --}}
        @if ( (!empty($bannerLink2Text)) && (!empty($previewBannerButtons[1])) )
            <a href="/{{$previewBannerButtons[1]['slug']}}">{{ $bannerLink2Text }}</a>
        @endif

        {{-- if we have at least 1 free article --}}
        @if ( ($previewFreeArticles[0] != NULL) || ($previewFreeArticles[1] != NULL) || ($previewFreeArticles[2] != NULL) )

            {{ $freeArticlesBlockHeading }}

            {{ $freeArticlesBlockText }}

            {{-- loops through the free articles --}}
            @foreach ($previewFreeArticles as $key => $value)

                {{-- if the article is not to NULL --}}
                @if ($value != NULL)
                    <a href="/articles/{{$value['slug']}}">
                        {{ $value['summary_heading'] }}
                        {{ $value['summary_text'] }}
                        <img src="{{ (!empty($value['summary_image'])) ? $value['summary_image'] : config('global.default_summary_images.summary_slot4-5-6')}}">
                    </a>
                @endif

            @endforeach

        @endif


        {{ $login_box_heading }}
        {{ $login_box_body }}
        <img src="{{ $login_box_banner_url }}">



        </div>
    </div>
</div>
