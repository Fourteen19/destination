@extends('admin.layouts.app')

@section('content')
Main report page<br>
<a href="{{ route('admin.reports.user-data') }}">user data report</a>
@endsection
