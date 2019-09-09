@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
</div>

@include('includes.list_submenu')

<div class="block">
    <p>Link for hosted subscribe page</p>
    <input type="text" value="{{ url(route('lists.subscribe', $list->id)) }}" disabled class="bg-gray-300 p-2 block w-1/2" >
</div>
		

@endsection