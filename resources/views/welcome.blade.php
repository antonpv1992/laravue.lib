<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Library</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
  <script defer="defer" src="{{ mix('js/app.js') }}"></script>
</head>
<body>
  <div id="app"></div>
</body>
</html>
