@if (($content->related_links) || ($content->related_downloads))
<div class="row mt-5">
    <div class="col">
        <div class="divider def-bg"></div>
        <h3 class="t30 fw700 mb-4">Things you'll need</h3>

        <ul class="list-unstyled">
        @if ($content->related_links)
            @foreach ($content->related_links as $item)
                <li class="mb-2"><a href="https://{{ $item->url }}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-link"></i></div>{{ $item->title }}</a></li>
            @endforeach
        @endif

        @if ($content->related_downloads)
            @foreach ($content->related_downloads as $item)
                <li class="mb-2"><a href="{{ $item->url }}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-cloud-download-alt"></i></div>{{ $item->title }}</a></li>
            @endforeach
        @endif
        </ul>
    </div>
</div>
@endif
