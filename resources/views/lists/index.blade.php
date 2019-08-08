@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Lists</h1>
  <a href="{{ route('lists.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Create new list</a>
</div>
  
  @foreach($lists as $list)
    <div class="flex justify-between flex-wrap p-4 border shadow mb-3" >
      <div>
        <h2 class="text-gray-600 text-2xl" ><a href="{{ route('lists.show', $list->id) }}" class="hover:text-blue-500" >{{ $list->name }}</a></h2>
        <p class="text-xs text-gray-600 leading-normal" >Created at {{ $list->created_at->format('Y-m-d') }} </span>
      </div>

      <div class="py-3 px-6" >{{ $list->contacts->count() }} subscribers</div>
    </div>
  @endforeach

@endsection