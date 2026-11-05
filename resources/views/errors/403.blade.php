@extends('errors.layout')

@section('title_tag', '403 - Access Denied | PRIMEGLOBOPTIONS')

@section('code', '403')

@section('icon')
<i class="ri-lock-2-line"></i>
@endsection

@section('title', 'Access Denied')

@section('message')
{{ $exception->getMessage() ?: "You don't have permission to access this resource. If you believe this is an error, please contact our support team." }}
@endsection

@section('actions')
<a href="/" class="err-btn err-btn--fill"><i class="ri-home-4-line"></i> Go Home</a>
<a href="{{ route('login') }}" class="err-btn err-btn--ghost"><i class="ri-login-box-line"></i> Sign In</a>
@endsection
