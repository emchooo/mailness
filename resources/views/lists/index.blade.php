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
            	<li>{{ $list->name }}</li>
           	@endforeach
		</ul>
                    
   	</div>
</body>
</html>