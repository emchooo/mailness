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
        <input type="text" name="fields[{{$field->id}}]" value="@if($contact->fields()->where('field_id', $field->id)->first()) {{ $contact->fields()->where('field_id', $field->id)->first()->pivot->value }} @endif" >
        </p>
    @endforeach

    <input type="submit">
    
    </form>
</body>

</html>