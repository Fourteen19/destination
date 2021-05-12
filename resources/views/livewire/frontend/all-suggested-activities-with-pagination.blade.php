<div>

    @if (count($activities) > 0)

        <div wire:loading.delay>
            Loading...
        </div>

        <div class="row r-sep">
            @foreach($activities as $value)

                <div class="col-3">
                    <a href="{{ route('frontend.activity', ['clientSubdomain' => session('fe_client.subdomain'), 'activity' => $value->slug]) }}" class="td-no ac-link">
                        <div class="square d-flex align-items-end" style="background-image: url({{parse_encode_url($value->getFirstMediaUrl('banner', 'banner_activity')) ?? ''}});">
                            <div class="blur-summary">
                                <h4 class="t20 fw700">{{$value->summary_heading}}</h4>
                            </div>
                            <div class="summary-extra t-w p-3">
                            <span class="fw700">{{$value->summary_heading}}</span>
                            <p>{{ Str::limit($value->summary_text, $limit = 147, $end = '...') }}</p>
                            </div>
                        </div>
                    </a>
                </div>

            @endforeach
        </div>

        <div class="row">
            <div class="col">
            {{ $activities->links('livewire.frontend.activities-pagination', ['clientSubdomain' => session('fe_client.subdomain')] ) }}
            </div>
        </div>

    @else

        <p>There are no suggested activities at this moment</p>

    @endif

</div>
