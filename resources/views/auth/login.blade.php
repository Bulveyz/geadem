@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/assetsLoginForm/css/styles.min.css')}}">
@endsection
@section('content')
  <div id='stars'></div>
  <div id='stars2'></div>
  <div id='stars3'></div>

  <div class="auth-form">
    <h2 class="text-center text-white mb-5">Log In</h2>
    <form action="/login" method="POST">
      @csrf
      <div class="form-group">
        <input class="form-control" name="name" type="text" placeholder="Login" value="{{old('name')}}">
      </div>
      <div class="form-group">
        <input class="form-control" name="password" type="password" placeholder="Password">
      </div>
      <div class="form-group">
        <button class="btn btn-success text-center w-100">Log In</button>
      </div>
      @if($errors->any())
        <p class="text-danger">{{$errors->first()}}</p>
      @endif
    </form>
  </div>
@endsection
