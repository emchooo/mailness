@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
  <a href="{{ route('contacts.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>

@include('includes.list_submenu')

@if($list->contacts()->count())
	<table class="w-full">
		<thead class="bg-gray-100" >
			<tr class="">
				<th class="py-2 px-4 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light text-left ">Email</th>
				@foreach($list->fields as $field)
					<th class="py-2 px-4 bg-grey-lightest font-bold  text-sm text-grey-dark border-b border-grey-light text-left" >{{ $field->name }}</th>
				@endforeach
				<th class="py-2 px-4 bg-grey-lightest font-bold  text-sm text-grey-dark border-b border-grey-light text-left" >Added</th>
			</tr>
		</thead>
		<tbody>
			@foreach($list->contacts as $contact)
				<tr class="hover:bg-gray-100" >
					<td class="py-4 px-4 border-b border-grey-light hover:text-gray-500" ><a href="{{ route('contacts.show', [ $list->id, $contact->id ]) }}">{{ $contact->email }}</a></td>
					@foreach($list->fields as $field)
						<td class="py-4 px-4 border-b border-grey-light" >{{ $contact->getFieldValue($field->id) }}</td>
					@endforeach
					<td class="py-4 px-4 border-b border-grey-light" >{{ $contact->created_at->format('Y-m-d') }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<p>no contacts yet</p>
@endif

@endsection