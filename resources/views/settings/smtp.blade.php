@extends('layouts.main')

@section('content')

<h3>Setup SMTP:</h3>

<form action="{{ route('settings.save.smtp') }}" method="POST" >
    @csrf

    <label for="Host">Host</label>
    <input type="text" name="host" class="block border" >
    @if($errors->has('host'))
        <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
            <p>{{ $errors->first('host') }}</p>
        </div>
	@endif
    
    <label for="Port">Port</label>
    <input type="text" name="port" class="block border" >
    @if($errors->has('port'))
        <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
            <p>{{ $errors->first('port') }}</p>
        </div>
	@endif

    <label for="Username">Username</label>
    <input type="text" name="username" class="block border">
    @if($errors->has('username'))
        <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
            <p>{{ $errors->first('username') }}</p>
        </div>
	@endif

    <label for="Password">Password</label>
    <input type="text" name="password" class="block border">
    @if($errors->has('password'))
        <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
            <p>{{ $errors->first('password') }}</p>
        </div>
	@endif

    <label for="Encription">Encription</label>
    <input type="text" name="encription" class="block border" >

    <input type="submit" value="Save" class="block border p-2 mt-3" >
</form>

@endsection