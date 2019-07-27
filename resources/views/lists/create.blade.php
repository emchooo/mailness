<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Create new list</h1>

	<form method="POST" action="{{ route('lists.store') }}" >
		@csrf

		<input type="text" name="name">

		<input type="submit" value="Save" >
		
	</form>

</body>
</html>