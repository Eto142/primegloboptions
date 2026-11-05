@extends('errors.layout')

@section('title_tag', '419 - Session Expired | PRIMEGLOBOPTIONS')

@section('code', '419')

@section('icon')
<i class="ri-timer-line"></i>
@endsection

@section('title', 'Session Expired')

@section('message')
Your session has expired for security reasons. This happens when a page is left open too long. Please refresh the page and try again.
@endsection

@section('actions')
<a href="javascript:location.reload()" class="err-btn err-btn--fill"><i class="ri-refresh-line"></i> Refresh Page</a>
<a href="{{ route('login') }}" class="err-btn err-btn--ghost"><i class="ri-login-box-line"></i> Sign In</a>
@endsection
