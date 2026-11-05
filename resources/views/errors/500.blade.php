@extends('errors.layout')

@section('title_tag', '500 - Server Error | PRIMEGLOBOPTIONS')

@section('code', '500')

@section('icon')
<i class="ri-error-warning-line"></i>
@endsection

@section('title', 'Something Went Wrong')

@section('message')
We encountered an unexpected error processing your request. Our team has been notified. Please try again shortly or contact support if the issue persists.
@endsection

@section('actions')
<a href="/" class="err-btn err-btn--fill"><i class="ri-home-4-line"></i> Go Home</a>
<a href="javascript:location.reload()" class="err-btn err-btn--ghost"><i class="ri-refresh-line"></i> Try Again</a>
@endsection
