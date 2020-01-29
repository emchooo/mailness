@extends('layouts.main')

@section('content')

<h3>Setup SMTP:</h3>

<form action="{{ route('settings.save.smtp') }}" method="POST" >
    @csrf

    <label for="Host">Host</label>
    <input type="text" name="host" class="block border" >
    
    <label for="Port">Portt</label>
    <input type="text" name="port" class="block border" >

    <label for="Username">Username</label>
    <input type="text" name="username" class="block border">

    <label for="Password">Password</label>
    <input type="text" name="password" class="block border">

    <label for="Encription">Encription</label>
    <input type="text" name="encription" class="block border" >

    <input type="submit" value="Save" class="block border p-2 mt-3" >
</form>

@endsection