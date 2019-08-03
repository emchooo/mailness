<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Edit field</h1>

	<form method="POST" action="{{ route('fields.update', [ $list->id , $field->id ] ) }}" >
    <input type="hidden" name="_method" value="PUT">

		@csrf

		<input type="text" name="name" value="{{ $field->name }}" >

		<input type="submit" value="Save" >
		
	</form>

</body>
</html>