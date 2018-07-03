<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>Geadem</title>
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/main.css')}}">
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  @if(!Request::is('login'))
    <link rel="stylesheet" href="{{asset('css/stars2.css')}}">
  @endif
  @yield('css')
</head>
<body>
<header>
  @include('layouts.header')
</header>
<main>
  @yield('content')
  @if(!Request::is('login'))
    <div id="particles-js"></div>
  @endif
</main>
@yield('js')
<script src="{{asset('js/app.js')}}"></script>
@if(!Request::is('login'))
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script src="{{asset('js/stars1.js')}}"></script>
@endif
<script>
  window.App = {!! json_encode([
            'signedIn' => Auth::check(),
            'user' => Auth::user()
        ]) !!};
</script>
</body>
</html>