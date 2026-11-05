@extends('errors.layout')

@section('title_tag', '429 - Too Many Requests | PRIMEGLOBOPTIONS')

@section('code', '429')

@section('icon')
<i class="ri-spam-2-line"></i>
@endsection

@section('title', 'Too Many Requests')

@section('message')
You've made too many requests in a short period. For security, please wait a moment before trying again.
@endsection

@section('actions')
<a href="javascript:location.reload()" class="err-btn err-btn--fill"><i class="ri-refresh-line"></i> Try Again</a>
<a href="/" class="err-btn err-btn--ghost"><i class="ri-home-4-line"></i> Go Home</a>
@endsection
