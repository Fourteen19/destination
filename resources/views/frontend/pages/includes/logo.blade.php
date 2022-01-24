@isset(request()->get('clientSettings')['logo'])
    <img src="{{request()->get('clientSettings')['logo']['url']}}" alt="{{request()->get('clientSettings')['logo']['alt']}}" class="{{$logo_class}}">
@endisset
