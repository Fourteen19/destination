@if (Session::has('clientSettings.logo.url'))
    <img src="{{Session::get('clientSettings')['logo']['url']}}" alt="{{Session::get('clientSettings')['logo']['alt']}}" class="{{$logo_class}}">
@endif
