<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<h1 class="title" >List - {{ $list->name }}</h1>

		<ul>
			@foreach($list->contacts as $contact)
				<li>{{ $contact->email }} 
					<a href="{{ route('contacts.show', [ $list->id, $contact->id ] ) }}">See</a> 
					<a href="{{ route('contacts.edit', [ $list->id, $contact->id ]) }}">Edit</a>
					<form action="{{ route('contacts.delete', $contact->id) }}" method="POST" >
						<input type="hidden" name="_method" value="DELETE">
						@csrf	
					<input type="submit" value="delete">
					</form>
				</li>
			@endforeach
		</ul>
                    
   	</div>
</body>
</html>