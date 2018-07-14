@extends('layouts.app')

@section('content')
    <div id="app">
        <channel-password channel="{{$channel->name}}"></channel-password>
    </div>
@endsection