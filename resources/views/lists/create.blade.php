@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4 px-2" >Create new list</h1>
</div>
		{!! Form::open(['route' => 'lists.store','method' => 'POST','class' => 'flex flex-col w-1/2']) !!}
		
		@include('lists._form')
		
		<div>
			<input type="submit" value="Create" class="m-2 p-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >
		</div>
	</form>
@endsection