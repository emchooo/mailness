@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Campaigns</h1>
  <a href="{{ route('campaigns.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Create new campaign</a>
</div>

@foreach($campaigns as $campaign)
    <div class="bg-gray-100 p-4 shadow flex justify-between" >
        <div>
        {{ $campaign->subject }} <span class="text-xs text-gray-500 pl-4" >{{ $campaign->status }}</span>
        </div>
        <div>
            <a href="{{ route('campaigns.edit', $campaign->id) }}">Edit</a>
            <a href="">Duplicate</a>
        </div>
    </div>
@endforeach

@endsection