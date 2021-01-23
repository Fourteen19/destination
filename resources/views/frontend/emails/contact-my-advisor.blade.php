@extends('frontend.emails.master')

@section('content')
    From: {{ $details['first_name'] }} {{ $details['last_name'] }} <br>
    Institution: {{ $details['institution']}} <br>
    Question related to: {{ $details['questionType']}} <br>
    Question: {{ $details['questionText'] }}
@endsection
