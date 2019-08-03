<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<h1 class="title" >Fields for {{ $list->name }}</h1>


		<ul>
            @foreach($list->fields as $field)
				<li> {{ $field->name }} </li>
				<form action="{{ route('fields.delete', [ $field->id, $field->id ] ) }}" method="POST" >
				<input type="hidden" name="_method" value="DELETE">
					@csrf
				<input type="submit" value="Delete">
				</form>
            @endforeach
		</ul>
		
		<a href="{{ route('fields.create', $list->id) }}">Create new field</a>
		
   	</div>
</body>
</html>