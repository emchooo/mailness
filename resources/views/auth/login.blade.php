<!DOCTYPE html>
<html>
<head>
  <title>Mailness</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="font-openSans bg-gray-200">

<div class="mb-3 mt-10 text-gray-600 text-center text-2xl">
    Mailness
</div> 

<div class="flex justify-center mt-10" >
<div class="w-full max-w-xs center">
  <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('login') }}" >
  @csrf
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
        Email
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="email" value="{{ old('email') }}" placeholder="Email address">
      @error('email')
        <p class="text-red-500 text-xs italic pt-2">{{ $message }}</p>
      @enderror
    </div>
    <div class="mb-3">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
        Password
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name="password" placeholder="******************">
      @error('password')
        <p class="text-red-500 text-xs italic pt-2">{{ $message }}</p>
      @enderror
    </div>
    <div class="mb-6">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} >
        <label class="text-gray-700 text-sm font-bold mb-2" for="remember">
            Remember Me
        </label>
    </div>
    <div class="flex items-center justify-between">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
        Login
      </button>
      <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">
        Forgot Password?
      </a>
    </div>
  </form>
</div>
</div>

</body>
</html>