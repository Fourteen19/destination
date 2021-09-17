<div class="row">
    <div class="col-12 text-center fw600">@if ($first_name) {{$first_name}} @endif  @if ($last_name) {{$last_name}} @endif</div>
    @if ($address)<div class="col-12 text-center">{{$address}}</div>@endif
    @if ($email)<div class="col-12 text-center">{{$email}}</div>@endif
    @if ($phone)<div class="col-12 text-center">{{$phone}}</div>@endif
</div>
