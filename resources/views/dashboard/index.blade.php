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
        Total compaint
        <span class="block" >0</span>
    </div>
    <div class="w-1/4 text-center" >
        Total bounced
        <span class="block" >0</span>
    </div>
</div>

<div class="flex mt-10" >
    <div class="w-1/2" >
        <h2>Campaigns</h2>
        <ul>
            <li>Campaign 1</li>
            <li>Campaign 2</li>
        </ul>
    </div>
    <div class="w-1/2" >
        <h2>Lists</h2>
        <ul>
            <li>List 1</li>
            <li>List 2</li>
        </ul>
    </div>
</div>

<div>
    <h2>Metrics</h2>

    <span>ADD graph</span>

</div>

@endsection