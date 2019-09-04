@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
  <a href="{{ route('contacts.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>

@include('includes.list_submenu')

<table class="w-1/3">
	<thead class="bg-gray-100">
		<tr>
			<th class="py-3 px-2 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light text-left ">Name</th>
			<th class="py-3 px-2 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light text-left ">Option</th>
		</tr>
	</thead>

	<tbody>
		@foreach($list->fields as $field)
			<tr class="border-b" >
				<td class="pb-2 pl-2">{{ $field->name }}</td>
				<td class="pb-2 pl-2">
					<form action="{{ route('fields.delete', [ $field->id, $field->id ] ) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
						@csrf
					<input type="submit" value="Delete" class="bg-red-600 py-1 px-3 rounded text-white" >
					</form>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

		
<a href="{{ route('fields.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center mt-5 inline-block" >Create new field</a>


@endsection