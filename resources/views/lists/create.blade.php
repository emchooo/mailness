@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4 px-2" >Create new list</h1>
</div>




	<form method="POST" action="{{ route('lists.store') }}" class="flex flex-col w-1/2" >
		@csrf

		<label for="name">Name</label>

		<input value="{{ old('name') }}" type="text" name="name" class="m-2 p-2 bg-gray-200 hover:bg-gray-100 hover:border-gray-900 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-303" placeholder="List name">

		<x-errorExists
		controlName="name">
		</x-errorExists>

		<label for="">From name</label>
		<input value="{{ old('from_name') }}" type="text" name="from_name" class="m-2 p-2 bg-gray-200 hover:bg-gray-100 hover:border-gray-900 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-303" placeholder="from name">

		<x-errorExists
		controlName="from_name">
		</x-errorExists>

		<label for="email">From email</label>
		<input value="{{ old('from_email') }}" type="text" name="from_email" class="m-2 p-2 bg-gray-200 hover:bg-gray-100 hover:border-gray-900 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-303" placeholder="from email">

		<x-errorExists
		controlName="from_email">
		</x-errorExists>

		<div class="block ml-2 my-2">
			<input type="checkbox" name="double_opt_in" value="1">
			<span>Double Opt-In</span>
		</div>

		<div>
			<input type="submit" value="Create" class="m-2 p-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >
		</div>
		
	</form>
@endsection