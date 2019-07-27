<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<h1>Contacts</h1>

<ul>
	@foreach($contacts as $contact)
		<li>{{ $contact->email }}</li>
	@endforeach
</ul>

</body>
</html>