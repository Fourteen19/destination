<div>
    @foreach($contents as $content)
        <a href="/content/{{ $content->uuid }}/{{ $content->title }}">{{ $content->title }}</a><br/>
    @endforeach
</div>
