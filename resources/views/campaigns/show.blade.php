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

    @if($errors->has('email'))
      <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
        <p>{{ $errors->first('email') }}</p>
      </div>
    @endif 

    @if(Session::has('success'))
    <div class="bg-red-100 border-l-4 border-green-500 text-green-700 p-2 mx-2" role="alert">
        <p>{{ Session::get('success') }}</p>
      </div>
      
    @endif

    <button type="submit" class="bg-blue-500 px-5 py-3 text-white mt-2" >Send</button> 
  </form>
</div>

<div class="mt-10">
  <h1>Send campaign</h1>

  @if($errors->has('lists'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('lists') }}</p>
    </div>
  @endif

  <form action="{{ route('campaigns.send', $campaign->id) }}" method="POST">
    @csrf

    @foreach($lists as $list)
      <div class="block" >
        <input type="checkbox" name="lists[{{$list->id}}]" > {{ $list->name }}
      </div>
    @endforeach

  <button type="submit" class="bg-blue-500 px-5 py-3 text-white mt-2" >Send</button>

  </form>

</div>


@endsection