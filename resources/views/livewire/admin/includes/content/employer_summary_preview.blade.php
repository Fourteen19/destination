<div id="summary_preview" class="tab-pane @if ($activeTab == "summary_preview") active @else fade @endif" wire:key="summary_preview-pane">
    <div class="row">
        <div class="col-lg-12">

            <h2>Summary Slot</h2>
            <div class="summary-slot-1 preview-canvas mb-5 vlg-bg">
                <div class="lhp-intro-banner d-flex align-items-end" style="background-image: url({{$summaryImageSlotPreview}})">

                    <div class="blur-summary">
                    <h3 class="t36 fw700">{{ $summary_heading }}</h3>
                    <div class="ep-sector lh1 t16">
                        @foreach($contentSectorsTags as $tag)
                            {{$tag}}<br/>
                        @endforeach
                    </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
