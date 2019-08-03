<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Create new field</h1>

	<form method="POST" action="{{ route('fields.store', $list->id) }}" >
		@csrf

		<input type="text" name="name">

		<input type="submit" value="Save" >
		
	</form>

</body>
</html>