<div id="summary_preview" class="tab-pane @if ($activeTab == "summary_preview") active @else fade @endif" wire:key="summary_preview-pane">
    <div class="row">
        <div class="col-lg-12">

            <h2>Summary Preview</h2>

            {{--
            <div class="summary-slot-1 preview-canvas mb-5 vlg-bg">
                <div class="lhp-intro-banner d-flex align-items-end" style="background-image: url({{$summaryImageSlotPreview}})">

                    <div class="blur-summary">
                    <h3 class="t36 fw700">{{ $summary_heading }}</h3>
                    {{ Str::limit($summary_text, $limit = 210, $end = '...') }}
                    </div>

                </div>
            </div>
            --}}
            <div class="summary-slot-1 preview-canvas mb-5 vlg-bg px-5">
                <div class="row">
                    <div class="col-3">
                        <span class="td-no ac-link">
                            <div class="square d-flex align-items-end" style="background-image: url({{$summaryImageSlotPreview}})">
                                <div class="blur-summary">
                                    <h4 class="t20 fw700">{{ $summary_heading }}</h4>
                                </div>
                                <div class="summary-extra t-w p-3">
                                <span class="fw700">{{ $summary_heading }}</span>
                                <p>{{ Str::limit($summary_text, $limit = 150, $end = '...') }}</p>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
