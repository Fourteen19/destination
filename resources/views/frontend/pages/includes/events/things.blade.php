@if ( ($event->relatedLinks->count() > 0) || ($event->getMedia('supporting_downloads')->count() > 0) )
<div class="row mt-4">
    <div class="col">
        <div class="divider def-bg"></div>
        <h3 class="t30 fw700 mb-4">Things you'll need</h3>

        <ul class="list-unstyled">
            @if ($event->relatedLinks->count() > 0)
                @foreach ($event->relatedLinks as $item)
                    <li class="mb-2"><a href="https://{{ $item->url }}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-link"></i></div>{{ $item->title }}</a></li>
                @endforeach
            @endif

            @foreach ($event->getMedia('supporting_downloads') as $key => $value)
                <li class="mb-2"><a href="{{ $value->getUrl('') }}" class="td-no fw700" target="_blank"><div class="tyn-icon gg-bg t-w"><i class="fas fa-cloud-download-alt"></i></div>{{ $value->getCustomProperty('title') }}</a></li>
            @endforeach

        </ul>
    </div>
</div>
@endif
