@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Create new campaign</h1>
</div>

<form action="{{ route('campaigns.store') }}" method="POST" >
@csrf 

<input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject" class="bg-gray-300 p-2 mb-2 block">  

<x-errorExists
controlName="subject">
</x-errorExists>

<input type="text" name="sending_name" value="{{ old('sending_name') }}" placeholder="Sending name" class="bg-gray-300 mb-2 p-2 block">

<x-errorExists controlName="sending_name"> </x-errorExists>

<input type="text" name="sending_email" value="{{ old('sending_email') }}" placeholder="Sending email" class="bg-gray-300 mb-2 p-2 block" >

<x-errorExists controlName="sending_email"> </x-errorExists>

  <div class="block">
    <input type="checkbox" name="track_clicks" value="1" >
    <label for="track_clicks">Track clicks</label>
  </div>

  <x-errorExists controlName="track_clicks"> </x-errorExists>

  <div class="block">
    <input type="checkbox" name="track_opens" value="1" >
    <label for="track_opens">Track opens</label>
  </div>

  <x-errorExists controlName="track_opens"> </x-errorExists>

  <div>
    Select template:
    
    @foreach($templates as $templateId => $templateName)
      <div class="block" >
        <input type="radio" name="template" value="{{ $templateId }}" >
        {{ $templateName }}
      </div>
    @endforeach
  </div>


<input type="submit" value="Save" class="bg-blue-500 px-4 py-2 text-white mt-3" >

</form>


@endsection