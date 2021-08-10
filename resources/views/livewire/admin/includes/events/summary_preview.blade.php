<div id="summary_preview" class="tab-pane @if ($activeTab == "summary_preview") active @else fade @endif" wire:key="summary_preview-pane">
    <div class="row">
        <div class="col-lg-12">



            <h2>Event Summary</h2>
            <div class="preview-canvas mb-5 vlg-bg px-4">
                <div class="col-sm-3">

                            <div class="w-bg">
                                <img src="{{parse_encode_url($summaryImageSlotLargePreview)}}" onerror="this.style.display='none'">
                                <div class="row no-gutters">
                                    <div class="col-8">
                                        <div class="article-summary mlg-bg mbh-1">
                                        <h4 class="fw700 t20">{{ $summary_heading }}</h4>
                                        <p class="t16 mb-0">{{ Str::limit($summary_text, $limit = 100, $end = '...') }}</p>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="event-summary p-3 w-bg t-up text-center fw700">
                                            <div class="row">
                                                <div class="col t48">
                                                    @if ($event_date){{ \Carbon\Carbon::createFromFormat('d/m/Y', $event_date)->format('d')}}@endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col t24">
                                                    @if ($event_date){{ \Carbon\Carbon::createFromFormat('d/m/Y', $event_date)->format('M')}}@endif
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col">
                                                    <div class="split border-top def-border w-100"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col t16">
                                                    <span>Starts:<br>
                                                        {{str_pad($start_time_hour, 2, "0", STR_PAD_LEFT)}}:{{str_pad($start_time_min, 2, "0", STR_PAD_LEFT)}}
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                </div>
            </div>

        </div>
    </div>
</div>
