@extends('layouts.main')

@section('content')

<h3>Report</h3>

<p>Links: {{ $campaign->linksTracking->count() }}</p>

<p>Opens: {{ $campaign->opensTracking->count() }}</p>

@endsection