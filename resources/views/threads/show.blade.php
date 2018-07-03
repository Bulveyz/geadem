@extends('layouts.app')

@section('content')
  <div id="app">
    <div class="container">
      <thread inline-template>
          <div>
            <div class="row mb-5 no-gutters">
              <div class="col-md-8 thread-show thread-body p-3">
                <h3 class="mb-5">{{$thread->title}}</h3>
                <p>
                  {{$thread->body}}
                </p>
              </div>
              <div class="col-md-3 offset-md-1 thread-show thread-sidebar p-3">
                <p>Creator: {{$thread->creator->name}}</p>
                <p>Published: {{$thread->created_at->diffForHumans()}}</p>
              </div>
            </div>
            <replies :thread-id="{{$thread->id}}"></replies>
          </div>
      </thread>
    </div>
  </div>
@endsection