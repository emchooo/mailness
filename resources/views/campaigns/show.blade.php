@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Campaign {{ $campaign->subject }}</h1>
</div>

<div>
  <h3>Send test campaign to:</h3>
  <form action="{{ route('campaigns.send.test', $campaign->id) }}" method="POST" > 
    @csrf
    <input type="text" name="email" placeholder="Email" class="block bg-gray-300 p-2" >
    <button type="submit" class="bg-blue-500 px-5 py-3 text-white mt-2" >Send</button> 
  </form>
</div>


@endsection