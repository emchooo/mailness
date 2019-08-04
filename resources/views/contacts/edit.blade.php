<html>
<head>
    <title>Edit contact</title>
</head>

<body>

    <form action="{{ route('contacts.update', [ $list->id , $contact->id ] ) }}" method="POST">
    <input type="hidden" name="_method" value="PUT">
    @csrf

    <input type="text" name='email' value="{{ $contact->email }}" >

    @foreach($list->fields as $field)
        <p>
        {{ $field->name }}
        <input type="text" name="fields[{{$field->id}}]" value="{{ $contact->getFieldValue($field->id) }}" >
        </p>
    @endforeach

    <input type="submit">
    
    </form>
</body>

</html>