@extends('layouts.main')

@section('content')
  
<h1>Dashboard</h1>

@if(false)
    <div class="bg-red-200 p-4 mt-2 mb-2" >
        You need to setup sending data
    </div>
@endif

<div class="flex shadow-lg rounded-lg mt-10 p-5 " >
    <div class="w-1/4 text-center" >
        Contacts
        <span class="block" >{{ $contacts }}</span>
    </div>
    <div class="w-1/4 text-center" >
        Total sent 
        <span class="block" >{{ $sent }}</span>
    </div>
    <div class="w-1/4 text-center" >
        Total complaint
        <span class="block" >{{ $complaint }}</span>
    </div>
    <div class="w-1/4 text-center" >
        Total bounced
        <span class="block" >{{ $bounced }}</span>
    </div>
</div>

<div class="flex mt-10" >
    <div class="w-1/2 shadow-lg rounded-lg p-5  " >
        <h2>Campaigns</h2>
        @if($campaigns->count() > 0)
        <ul >
            @foreach($campaigns as $campaign)
                <li class="pt-2" ><a href="{{ route('campaigns.show', $campaign->id) }}">{{ $campaign->subject }}</a></li>
            @endforeach
        </ul>
        @else
            <a href="{{ route('campaigns.create') }}">Crete new campaign</a>
        @endif
    </div>
    <div class="w-1/2 shadow-lg rounded-lg p-5 " >
        <h2>Lists</h2>
        @if($lists->count() > 0)
            <ul>
                @foreach($lists as $list)
                    <li><a href="{{ route('lists.show', $list->id) }}">{{ $list->name }}</a></li>
                @endforeach
            </ul>
        @else

        @endif
    </div>
</div>

<div class="mt-5" >
    <h2 class="pb-3" >Metrics</h2>

    <span>ADD graph</span>

</div>

@endsection