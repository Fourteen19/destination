<div id="summary_preview" class="tab-pane @if ($activeTab == "summary_preview") active @else fade @endif" wire:key="summary_preview-pane">
    <div class="row">
        <div class="col-lg-12">

            <h2>Summary Slot Size 1 (e.g Home page lead banner)</h2>
            <div class="summary-slot-1 preview-canvas mb-5 vlg-bg">
                <div class="lhp-intro-banner d-flex align-items-end" style="background-image: url({{parse_encode_url($summaryImageSlot1Preview)}})">

                    <div class="blur-summary">
                    <h3 class="t36 fw700">{{ $summary_heading }}</h3>
                    {{ Str::limit($summary_text, $limit = 210, $end = '...') }}
                    </div>

                </div>
            </div>

            <h2>Summary Slot Size 2 (e.g Home page 2nd & 3rd article)</h2>
            <div class="preview-canvas mb-5 vlg-bg">
                <div class="summary-slot-2-3">
                <div class="row no-gutters">
                    <div class="col-lg-7">

                        <img src="{{parse_encode_url($summaryImageSlot23Preview)}}">

                    </div>
                    <div class="col-lg-5 w-bg">
                        <div class="article-summary">
                        <h3 class="t20 fw700">{{ $summary_heading }}</h3>
                        <p class="t16 mb-0">{{ Str::limit($summary_text, $limit = 120, $end = '...') }}</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <h2>Summary Slot Size 3 (e.g Home page 4th article)</h2>
            <div class="summary-slot-4-6 preview-canvas mb-5 vlg-bg">
                <div class="article-block-link">
                <img src="{{parse_encode_url($summaryImageSlot456Preview)}}">
                    <div class="w-bg article-summary">
                        <h3 class="t20 fw700">{{ $summary_heading }}</h3>
                        <p class="t16">{{ Str::limit($summary_text, $limit = 175, $end = '...') }}</p>
                    </div>
                </div>
            </div>

            <h2>Summary Slot Size 4 (e.g You might also like)</h2>
            <div class="preview-canvas mb-5 vlg-bg">
                <div class="summary-slot-yml">
                    <div class="square d-flex align-items-end" style="background-image: url('{{$summaryImageYouMightLikePreview}}')">
                        <div class="blur-summary"><h4 class="t20 fw700">{{ $summary_heading }}</h4></div>
                    </div>
                </div>
            </div>

            <h2>Summary Slot Size 5 (e.g Search result)</h2>
            <div class="preview-canvas mb-5 vlg-bg">
                <div class="summary-slot-sr">
                    <img src="{{parse_encode_url($summaryImageSearchPreview)}}">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <div class="article-summary mlg-bg mbh-1">
                            <h4 class="fw700 t20">{{ $summary_heading }}</h4>
                            <p class="t16 mb-0">{{ Str::limit($summary_text, $limit = 140, $end = '...') }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
