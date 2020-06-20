@extends('layouts.main')

@section('content')

<h3>Setup AWS:</h3>

<form action="{{ route('settings.save.aws') }}" method="POST">
    @csrf
    <label for="Key">Key</label>
    <input type="text" name="key" class="block border" >
    
    <label for="Secret">Secret</label>
    <input type="text" name="secret" class="block border" >

    <label for="Region">Region</label>
    <input type="text" name="region" class="block border">

    <input type="submit" value="Save" class="block border p-2 mt-3" >
</form>


@endsection