@extends('layouts.main')

@section('content')

<h1 class="text-xl py-5" >Report - {{ $campaign->subject }}</h3>

<ul class="py-2" >
    <li class="inline pr-5 text-blue-500 " ><a href="{{ route('campaigns.report', $campaign->id) }}">Preview</a></li>
    <li class="inline px-5 " ><a href="{{ route('campaigns.report.opens', $campaign->id) }}">Link for list of opens</a></li>
    <li class="inline px-5" ><a href="{{ route('campaigns.report.clicks', $campaign->id) }}">Link for list of clicks</a></li>
    <li class="inline px-5" ><a href="{{ route('campaigns.report.unsubscribed', $campaign->id) }}">Link for list of unsubscribed users</a></li>
</ul>

<p class="text-xl" >Mails sent: {{ $campaign->sent_to_number }}</p>

<div class="block py-5">
    <p>Opens: {{ $campaign->opens->count() }}</p>
    <p>Unique opens: {{ $campaign->uniqueOpens()->count() }}</p>
    <p>Open rate: {{ round($campaign->uniqueOpens()->count() / $campaign->sent_to_number,2) * 100  }}% </p>
</div>

<div class="block py-5">
    <p>Clicks: {{ $campaign->clicks->count() }}</p>
    <p>Unique clicks: {{ $unique_clicks }}</p>
    <p>Click rate: {{ round( $unique_clicks / $campaign->sent_to_number, 2 ) * 100 }}% </p>
</div>

<div class="block py-5">
    <p>Bounced: {{ $campaign->totalBounced->count() }} </p>
    <p>Bounce rate: {{ round( $campaign->totalBounced->count() / $campaign->sent_to_number, 2 ) * 100 }}%</p>
</div>

<div class="block py-5">
    <p>Complaint: {{ $campaign->totalComplaint->count() }}</p>
    <p>Complaint rate: {{ round( $campaign->totalComplaint->count() / $campaign->sent_to_number, 2 ) * 100 }}%</p>
</div>

<div class="block py-5">
    <p>unsubscribed: {{ $campaign->totalUnsubscribed->count() }}</p>
    <p>Unsubscribe rate: {{ round( $campaign->totalUnsubscribed->count() / $campaign->sent_to_number, 2 ) * 100 }}%</p>
</div>


@endsection