@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($channels as $channel)
            <div class="channel rounded p-3 mb-3">
                <h4><a class="text-white" href="/channel/{{$channel->slug}}">{{$channel->name}}</a></h4>
            </div>
        @endforeach
    </div>
@endsection