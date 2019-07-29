<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<h1 class="title" >Lists</h1>

		<a href="{{ route('lists.create') }}">Create list</a>

		<ul>
			@foreach($lists as $list)
            	<li>  <a href="{{ route('lists.show', $list->id) }}">{{ $list->name }}</a> <a href="{{ route('lists.edit', $list->id ) }}">Edit</a> </li>
           	@endforeach
		</ul>
                    
   	</div>
</body>
</html>