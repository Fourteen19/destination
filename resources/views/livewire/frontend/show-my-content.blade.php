<div>
    @foreach($contents as $content)
        <a href="/{{ $content->slug }}">{{ $content->title }}</a><br/>
    @endforeach
</div>
