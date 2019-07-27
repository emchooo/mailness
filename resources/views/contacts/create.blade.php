<html>
<head>
    <title>Create new contact</title>
</head>

<body>
    <h1>Create new contact to {{ $list->name }}</h1>

    <form action="{{ route('contacts.store', $list->id) }}" method="POST">
    @csrf

    <input type="text" name='email' > 

    <input type="submit">
    
    </form>
</body>

</html>