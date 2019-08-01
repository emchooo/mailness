<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<h1>Contact {{ $contact->email }}</h1>

@foreach($contact->list->fields as $field)
	{{ $field->name }}
@endforeach

<br>
<br>

@foreach($contact->fields as $f)
	{{ $f->field->name }} : {{ $f->value }}
@endforeach

</body>
</html>