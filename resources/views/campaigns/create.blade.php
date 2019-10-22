@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Create new campaign</h1>
</div>

<form action="{{ route('campaigns.store') }}" method="POST" >
@csrf 

<input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject" class="bg-gray-300 p-2 mb-2 block">  

  @if($errors->has('subject'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('subject') }}</p>
    </div>
  @endif

<input type="text" name="sending_name" value="{{ old('sending_name') }}" placeholder="Sending name" class="bg-gray-300 mb-2 p-2 block">

@if($errors->has('sending_name'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('sending_name') }}</p>
    </div>
  @endif


<input type="text" name="sending_email" value="{{ old('sending_email') }}" placeholder="Sending email" class="bg-gray-300 mb-2 p-2 block" >
@if($errors->has('sending_email'))
    <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
      <p>{{ $errors->first('sending_email') }}</p>
    </div>
  @endif

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