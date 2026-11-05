@extends('errors.layout')

@section('title_tag', '404 - Page Not Found | PRIMEGLOBOPTIONS')

@section('code', '404')

@section('icon')
<i class="ri-compass-discover-line"></i>
@endsection

@section('title', 'Page Not Found')

@section('message')
The page you're looking for doesn't exist or may have been moved. Please check the URL or navigate back to a safe page.
@endsection

@section('actions')
<a href="/" class="err-btn err-btn--fill"><i class="ri-home-4-line"></i> Go Home</a>
<a href="javascript:history.back()" class="err-btn err-btn--ghost"><i class="ri-arrow-left-line"></i> Go Back</a>
@endsection
