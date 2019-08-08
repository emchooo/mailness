<!DOCTYPE html>
<html>
<head>
  <title>Mailness</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="font-openSans">

    @include('layouts.menu')

    <div class="container mx-auto pt-5">
      @yield('content')
    </div>
    

</body>
</html>