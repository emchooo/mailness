<html>
<head>
    <title>Edit contact</title>
</head>

<body>

    <form action="{{ route('contacts.update', [ $list->id , $contact->id ] ) }}" method="POST">
    <input type="hidden" name="_method" value="PUT">
    @csrf

    <input type="text" name='email' value="{{ $contact->email }}" > 

    <input type="submit">
    
    </form>
</body>

</html>