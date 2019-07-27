<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Edit list</h1>

	<form method="POST" action="{{ route('lists.update', $list->id) }}" >
    <input type="hidden" name="_method" value="PUT">

		@csrf

		<input type="text" name="name" value="{{ $list->name }}" >

		<input type="submit" value="Save" >
		
	</form>

</body>
</html>