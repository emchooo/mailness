@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Campaigns</h1>
  <a href="{{ route('campaigns.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Create new campaign</a>
</div>

@foreach($campaigns as $campaign)
    <div class="bg-gray-100 p-4 shadow flex justify-between mb-2 " >
        <div>
            <a href="{{ route('campaigns.show', $campaign->id) }}">{{ $campaign->subject }} </a> 
            <span class="text-xs text-gray-500 pl-4" >{{ $campaign->status }}</span>
        </div>
        <div>
            @if($campaign->isDraft())
                <a href="{{ route('campaigns.edit', $campaign->id) }}" class="bg-gray-200 px-2 py-1 rounded border" >Edit</a>
            @endif
            <form action="{{ route('campaigns.duplicate', $campaign->id) }}" method="POST" >
                @csrf   
                <input type="submit" value="Duplicate" class="bg-gray-200 px-2 py-1 rounded border" >
            </form>
            <form action="{{ route('campaigns.delete', $campaign->id) }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value="Delete" class="bg-gray-200 px-2 py-1 rounded border" >
            </form>
        </div>
    </div>
@endforeach

{{ $campaigns->links('includes.pagination') }}

@endsection