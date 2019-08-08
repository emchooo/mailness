@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4 px-2" >Create new list</h1>
</div>




	<form method="POST" action="{{ route('lists.store') }}" class="flex flex-col w-1/2" >
		@csrf

		<input type="text" name="name" class="m-2 p-2 bg-gray-200 hover:bg-gray-100 hover:border-gray-900 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-303" placeholder="List name">

		@if($errors->has('name'))
			<div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
				<p>{{ $errors->first('name') }}</p>
			</div>
		@endif

		<div>
			<input type="submit" value="Create" class="m-2 p-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >
		</div>
		
	</form>
@endsection