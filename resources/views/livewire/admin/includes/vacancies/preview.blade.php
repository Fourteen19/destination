<div id="vacancy-preview" class="tab-pane px-0 @if ($activeTab == "vacancy-preview") active @else fade @endif" wire:key="vacancy-preview-pane">
    <div class="row justify-content-center">
        <div class="col-xl-12">

            <div class="preview-canvas">

                <div class="row r-sep align-items-center">
                    <div class="col-xl-9 col-lg-8 col-sm-7">
                        <div class="p-ws">
                            <h1 class="fw700 t36">{{$title}}</h1>
                            <ul class="list-unstyled t24">
                                <li>Location: <span class="fw700">{{$region_name}}</span></li>
                                <li>Posted: <span class="fw700">{{$posted_at}}</span></li>
                                <li>Employer: <span class="fw700">{{$employer_name}}</span></li>
                                <li>Role type: <span class="fw700">{{$role_type_name}}</span></li>
                                @if ($entry_requirements)
                                    <li>Entry Requirements: <span class="fw700">{!! $entry_requirements !!}</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-5">
                        <img src="{{parse_encode_url($vacancyImagePreview)}}" onerror="this.style.display='none'">
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-2 mb-5">
                        <div class="border-top gg-border"></div>
                    </div>
                </div>

                <div class="row justify-content-between">
                    <div class="col-lg-8  mb-5 mb-lg-0">

                        <p class="t24 mb-4">{{$lead_para}}</p>

                        <div class="article-body">{!! $description !!}</div>

                        <div class="article-body">{!! $entry_requirements !!}</div>

                        @if ($relatedVideos)
                        <div class="vid-block my-5">
                            <h3 class="t24 fw700 mb-3">Watch the video</h3>
                            @foreach($relatedVideos as $key => $item)
                                <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{$item['url']}}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        @if (!empty($vac_map))
                            <div class="map mt-5">
                                <h3 class="t24 fw700 mb-3"><i class="fas fa-map-marked fa-lg mr-3"></i>How to get there</h3>

                                <div class="embed-responsive embed-responsive-21by9">
                                    {!!$vac_map!!}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-xl-3 text-center pb-5 pb-lg-0">
                        @if ($employerLogoUrl)
                            <img src="{{parse_encode_url($employerLogoUrl)}}" onerror="this.style.display='none'">
                            <div class="border-top gg-border my-4"></div>
                        @endif
                        <div class="table-responsive mb-3">
                            <table class="table table-borderless">
                            <tbody>

                                @if (!empty($contact_name))
                                    <tr>
                                        <td width="5%"><i class="fas fa-user-circle fa-lg"></i></td>
                                        <td class="text-left">Contact<br><span class="fw700">{{$contact_name}}</span></td>
                                    </tr>
                                @endif

                                @if (!empty($contact_email))
                                    <tr>
                                        <td><i class="fas fa-at fa-lg"></i></td>
                                        <td class="text-left"><a href="mailto:{{$contact_email}}" class="fw700 td-no">{{$contact_email}}</a></td>
                                    </tr>
                                @endif

                                @if (!empty($contact_number))
                                    <tr>
                                        <td><i class="fas fa-phone-square fa-lg"></i></td>
                                        <td class="text-left"><a href="tel:{{$contact_number}}" class="fw700 td-no">{{$contact_number}}</a></td>
                                    </tr>
                                @endif

                                @if (!empty($contact_link))
                                    <tr>
                                        <td><i class="fas fa-link fa-lg"></i></td>
                                        <td class="text-left"><a href="{{$contact_link}}" class="fw700 td-no">Company website</a></td>
                                    </tr>
                                @endif
                            </tbody>
                            </table>
                        </div>
                        @if (!empty($online_link))
                            <a href="{{ $online_link }}" class="platform-button pb-lge pb-inv">Apply online</a>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
