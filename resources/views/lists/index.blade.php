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
            	<li>  <a href="{{ route('lists.show', $list->id) }}">{{ $list->name }}</a> <a href="{{ route('lists.edit', $list->id ) }}">Edit</a> 
					<form action="{{ route('lists.delete', $list->id) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
					@csrf
						<input type="submit" value="DELETE">
					</form>
				</li>
           	@endforeach
		</ul>
                    
   	</div>
</body>
</html>