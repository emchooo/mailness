@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
</div>

@include('includes.list_submenu')

<a href="{{ route('forms.hosted', $list->id) }}">Hosted</a>
		

@endsection