@extends('frontend.emails.master')

@section('content')

    <div style="background-color: #e0e0e0; padding: 16px; border-radius:6px;">
        <div style="background-color: #fff; padding: 10px;">

            <p>You are receiving this email because we received a password reset request for your account.</p>

            <a href="{{$details['reset_url']}}">Reset Password</a>

            <p>This password reset link will expire in {{$details['password_expiry_time']}} minutes.</p>

            <p>If you did not request a password reset, no further action is required.</p>

        </div>
    </div>

@endsection
