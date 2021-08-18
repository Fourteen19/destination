@extends('frontend.layouts.master')

@section('content')



<div class="row">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="@auth('web'){{ route('frontend.dashboard') }}@else{{ route('frontend.home') }}@endauth" class="fw700 td-no">Back to home page</a>
        </div>
    </div>
</div>

@endsection

