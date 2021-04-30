<section class="activity-banner bg-2 t-w mb-5">
    <div class="row mb-5 justify-content-between align-items-center">
        <div class="col-xl-5">
        <div class="heading-pre">Employer Profile</div>
        <h1 class="t30 fw700 t-w mb-4">{{ $content->title }}</h1>

        <div class="ac-intro t20"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
        </div>

        </div>
        <div class="col-xl-5">
            <div class="ac-ban-img"><img src="https://via.placeholder.com/1194x800/FFFFFF/5379a6?text=Employer+Logo"  class="img-fluid"></div>
            {{--
                @if (!empty($content->getFirstMediaUrl('banner')))
                @foreach ( $content->getMedia('banner') as $key => $value)
                    <div class="ac-ban-img"><img src="{{ $value->getUrl('banner_activity') }}" alt="{{$value->getCustomProperty('alt')}}"  class="img-fluid"></div>
                @endforeach
                @endif
            --}}
        </div>
    </div>
</section>
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12">

                <h2 class="t24 fw700 mb-4">{{ $content->subheading }}</h2>
                <p class="t24 mb-4">{{ $content->contentable->lead }}</p>
                <div class="article-body">{!! $content->contentable->body !!}</div>

            </div>
        </div>

        <div class="sup-img my-5">
            <img src="https://via.placeholder.com/1274x536/f74e77/f74e77?text=Banner">
            <div class="sup-img-caption vlg-bg p-3 t16 fw700">Image caption that goes with the supporting image block</div>
            </div>

            <div class="alternate-block my-5 mlg-bg p-5">
                <h2 class="t24 fw700">{{ $content->contentable->alt_block_heading }}</h2>
                <div class="alt-cols">

                {!! $content->contentable->alt_block_text !!}
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut sed aut, exercitationem sunt, asperiores beatae voluptatibus eveniet temporibus quisquam quos ad quae quis odit facilis aspernatur alias dicta, saepe rerum. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Omnis, consequatur tenetur minima magnam necessitatibus illum corporis, excepturi quaerat molestiae aperiam officiis ab ut reiciendis, nulla optio accusantium in? In, veniam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic maiores ut sequi temporibus a odit accusantium aliquam recusandae explicabo? Iure excepturi corrupti beatae at ipsam error magni quam aliquid necessitatibus! Pariatur aliquip tempor nisi labore amet in incididunt non ipsum irure incididunt qui duis anim. Elit fugiat do exercitation tempor sunt sint velit. Nisi minim laboris labore ipsum do occaecat qui consectetur aute eiusmod consectetur in. Fugiat nostrud proident id ipsum ex cupidatat in quis cupidatat sit culpa irure do pariatur. Sit do aliquip do duis officia.</p>
                <ul>
                    <li>Id excepteur ea irure quis velit aute.</li>
                    <li>Id excepteur ea irure quis velit aute.</li>
                    <li>Id excepteur ea irure quis velit aute.</li>
                </ul>
                </div>

            </div>

            @if ($content->videos)
                <div class="vid-block my-5">
                    <h3 class="t24 fw700 mb-3">Watch the video</h3>
                    @foreach ($content->videos as $item)
                        <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ $item->url }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="lower-text">
                <p>Duis dolore proident dolore consequat aute consequat nisi irure quis. Eiusmod enim dolor aute dolore magna ex ad sunt tempor irure. Qui ex sunt Lorem consectetur laboris deserunt ut adipisicing pariatur ea voluptate deserunt duis quis. Lorem Lorem ipsum irure non occaecat id ullamco eiusmod commodo irure exercitation officia nostrud laborum. Nostrud pariatur occaecat pariatur aliquip officia officia. Tempor ea laboris occaecat laboris ex nisi exercitation.</p>
            </div>
        
            

    </div>
    <div class="col-lg-4">
        
        <div class="row justify-content-end">
            <div class="col-lg-10">
                <div class="row vlg-bg r-pad">
                    <div class="col-lg-12">
                        <div class="heading-no-border w-bg">
                        <h2 class="t24 fw700 mb-0">Related Employers</h2>
                        </div>
                    </div>
                    <div class="col-lg-12 r-base">
                        <a href="#" class="td-no t-def">
                            <div class="square d-flex">
                                <div class="ep-inner">
                                    <div class="ep-logo"><img src="https://via.placeholder.com/250x50"></div>
                                    <div class="ep-summary">
                                        <div class="ep-pre t14 t-up fw600 lh0">Employer Profile:</div>
                                        <div class="ep-name t24">ASDA</div>
                                        <div class="ep-sector lh1 t16">Retail</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-lg-10">
                <div class="row vlg-bg r-pad">
                    <div class="col-lg-12">
                        <div class="heading-no-border w-bg">
                        <h2 class="t24 fw700 mb-0">An article you might like</h2>
                        </div>
                    </div>
                    <div class="col-lg-12 r-base">
                        <a href="#" class="article-block-link">
                        <img src="https://via.placeholder.com/1006x670.png?text=Article+Image">
                            <div class="w-bg article-summary">
                                <h3 class="t20">Client Y9-Healthcare-003</h3>
                                <p class="t16">Client Y9-Healthcare-003 summary text</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@include('frontend.pages.includes.things')

