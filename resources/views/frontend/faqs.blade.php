@extends('layouts.home')

@section('content')
    <div id="faqs">
        <faqs :questions="{{$questions->toJson()}}"></faqs>
    </div>
@endsection

@section('meta')
<meta name="description" content="{{$page->meta_description}}" />
<meta name="keywords" content="{{$page->meta_keywords}}" />
<meta name="robots" content="{{ $page->meta_robots }}" />
@endsection

@section('title')
    <title>{{ env('APP_NAME') }} @if ($page != null)| {{ $page->title }}@endif</title>
@endsection