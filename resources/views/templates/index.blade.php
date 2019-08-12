@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Templates</h1>
  <a href="{{ route('templates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Create new template</a>
</div>

@foreach($templates as $template)
    <div class="p-3 border shadow mb-2 flex justify-between" >
        {{ $template->name }}
        <div>
            <a href="{{ route('templates.edit', $template->id) }}" class="bg-blue-500 px-4 py-1 text-white rounded" >Edit</a>
            
            <form action="{{ route('templates.delete', $template->id) }}" method="POST" >
            @csrf
            <input type="hidden" name="_method" value="DELETE">

                <button type="submit" class="bg-red-500 px-4 py-1 text-white rounded mt-1" >Delete</button>
            </form>
        </div>
    </div>
@endforeach

@endsection