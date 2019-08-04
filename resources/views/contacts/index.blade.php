<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<body>

<h1>Contacts</h1>

<a href="{{ route('contacts.create',$list->id) }}">Add new contact</a>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Email</th>
			@foreach($list->fields as $field)
				<th>{{ $field->name }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach($list->contacts as $contact)
			<tr>
				<td>{{ $contact->id }}</td>
				<td>{{ $contact->email }}</td>
				@foreach($list->fields as $field)
					<td>{{ $contact->getFieldValue($field->id) }}</td>
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>

</body>
</html>