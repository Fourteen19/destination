<div id="summary_preview" class="tab-pane @if ($activeTab == "summary_preview") active @else fade @endif" wire:key="summary_preview-pane">
    <div class="row">
        <div class="col-lg-12">

            <h2>Summary Slot Size Large</h2>
            <div class="summary-slot-1 preview-canvas mb-5 vlg-bg">
                <div class="lhp-intro-banner d-flex align-items-end" style="background-image: url({{parse_encode_url($summaryImageSlotLargePreview)}})">

                    <div class="blur-summary">
                    <h3 class="t36 fw700">{{ $summary_heading }}</h3>
                    {{ Str::limit($summary_text, $limit = 210, $end = '...') }}
                    </div>

                </div>
            </div>

            <h2>Summary Slot Size Small</h2>
            <div class="preview-canvas mb-5 vlg-bg">
                <div class="summary-slot-2-3">
                <div class="row no-gutters">
                    <div class="col-lg-7">

                        <img src="{{parse_encode_url($summaryImageSlotSmallPreview)}}">

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

        </div>
    </div>
</div>
