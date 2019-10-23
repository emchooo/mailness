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
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" >
    <h1 class="text-center" >Thank you for subscribing. <b> {{$list->name}} <b></h1>
    </div>
</div>
</div>

</body>
</html>