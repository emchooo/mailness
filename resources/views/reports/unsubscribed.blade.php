@extends('layouts.main')

@section('content')

<h1 class="text-xl py-5" >Report - {{ $campaign->subject }}</h3>

<ul class="py-2" >
<li class="inline pr-5 text-blue-500 " ><a href="{{ route('campaigns.report', $campaign->id) }}">Preview</a></li>
    <li class="inline px-5 " ><a href="{{ route('campaigns.report.opens', $campaign->id) }}">Link for list of opens</a></li>
    <li class="inline px-5" ><a href="#">Link for list of clicks</a></li>
    <li class="inline px-5" ><a href="#">Link for list of unsubscribed users</a></li>
</ul>

<h2>List of unsubscribed</h2>

{{ $campaign->totalUnsubscribed }}

@endsection