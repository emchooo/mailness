@extends('layouts.main')

@section('content')

<h3>List all reports</h3>

    @foreach($reports as $report)
    <div class="bg-gray-100 p-4 shadow flex justify-between">
        <div>
            <a href="{{ route('campaigns.report', $report->id) }}">{{ $report->subject }}</a>
        </div>
    </div>
    @endforeach

@endsection