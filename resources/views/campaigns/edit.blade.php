@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Edit campaign</h1>
</div>

<form action="{{ route('campaigns.update', $campaign->id) }}" method="POST" >
  @method('PUT')
  @csrf 

<input type="text" name="subject" placeholder="Subject" class="bg-gray-300 p-2 mb-2 block" value="{{ $campaign->subject }}"> 

<x-errorExists
controlName="subject">
</x-errorExists>

<input type="text" name="sending_name" placeholder="Sending name" class="bg-gray-300 mb-2 p-2 block" value="{{ $campaign->sending_name }}">

<x-errorExists
controlName="sending_name">
</x-errorExists>


<input type="text" name="sending_email" placeholder="Sending email" class="bg-gray-300 mb-2 p-2 block" value="{{ $campaign->sending_email }}" >

<x-errorExists
controlName="sending_email">
</x-errorExists>

  <div class="block">
    <input type="checkbox" name="track_clicks" @if($campaign->track_clicks) checked @endif value="1" >
    <label for="track_clicks">Track clicks</label>
  </div>
  @if($errors->has('track_clicks'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('track_clicks') }}</p>
    </div>
  @endif

  <div class="block">
    <input type="checkbox" name="track_opens" @if($campaign->track_opens) checked @endif value="1" >
    <label for="">Track opens</label>
  </div>
  @if($errors->has('track_opens'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('track_opens') }}</p>
    </div>
  @endif

<textarea name="html" id="" cols="30" rows="10" class="bg-gray-300 mb-2 p-2 block" >{{ $campaign->html }}</textarea>

<input type="submit" value="Save" class="bg-blue-500 px-4 py-2 text-white" >

</form>

<div class="block mt-10">
  <form action="{{ route('campaigns.delete', $campaign->id) }}" method="POST" >
  <input type="hidden" name="_method" value="DELETE">
    @csrf 
    <input type="submit" value="Delete" class="bg-red-500 px-4 py-2 text-white">
  </form>
</div>

@endsection

@push('pageSpecificJS')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('html', {
		fullPage: true,
	});
</script>
@endpush