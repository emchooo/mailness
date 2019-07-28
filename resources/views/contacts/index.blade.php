<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<h1>Contacts</h1>

<a href="{{ route('contacts.create',$list->id) }}">Add new contact</a>

<ul>

	@foreach($list->contacts as $contact)
		<li>{{ $contact->email }}</li>
	@endforeach
</ul>

</body>
</html>