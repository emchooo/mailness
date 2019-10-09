@extends('layouts.main')

@section('content')

<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Edit campaign</h1>
</div>

<form action="{{ route('campaigns.update', $campaign->id) }}" method="POST" >
<input type="hidden" name="_method" value="PUT">
@csrf 

<input type="text" name="subject" placeholder="Subject" class="bg-gray-300 p-2 mb-2 block" value="{{ $campaign->subject }}"> 
@if($errors->has('subject'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('subject') }}</p>
    </div>
  @endif

<input type="text" name="sending_name" placeholder="Sending name" class="bg-gray-300 mb-2 p-2 block" value="{{ $campaign->sending_name }}">

@if($errors->has('sending_name'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('sending_name') }}</p>
    </div>
  @endif

<input type="text" name="sending_email" placeholder="Sending email" class="bg-gray-300 mb-2 p-2 block" value="{{ $campaign->sending_email }}" >
@if($errors->has('sending_email'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('sending_email') }}</p>
    </div>
  @endif

<textarea name="content" id="" cols="30" rows="10" class="bg-gray-300 mb-2 p-2 block" >{{ $campaign->content }}</textarea>

<input type="submit" value="Save" class="bg-blue-500 px-4 py-2 text-white" >

</form>

<div class="block mt-10">
  <form action="{{ route('campaigns.delete', $campaign->id) }}" method="POST" >
  <input type="hidden" name="_method" value="DELETE">
    @csrf 
    <input type="submit" value="Delete" class="bg-red-500 px-4 py-2 text-white">
  </form>
</div>

<script>
    CKEDITOR.replace( 'content' );
</script>

@endsection