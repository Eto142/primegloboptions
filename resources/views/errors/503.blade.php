@extends('errors.layout')

@section('title_tag', '503 - Under Maintenance | PRIMEGLOBOPTIONS')

@section('code', '503')

@section('icon')
<i class="ri-tools-line"></i>
@endsection

@section('title', 'Under Maintenance')

@section('message')
We're performing scheduled maintenance to improve your banking experience. We'll be back online shortly. Thank you for your patience.
@endsection

@section('actions')
<a href="javascript:location.reload()" class="err-btn err-btn--fill"><i class="ri-refresh-line"></i> Check Again</a>
<a href="mailto:support@primegloboptions.com" class="err-btn err-btn--ghost"><i class="ri-mail-line"></i> Contact Support</a>
@endsection
