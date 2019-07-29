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
				<li>{{ $contact->email }}</li>
			@endforeach
		</ul>
                    
   	</div>
</body>
</html>