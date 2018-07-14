@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="container">
            <thread inline-template>
                <div>
                    <div class="row mb-5 no-gutters">
                        <div class="col-md-8 thread-show thread-body p-3">
                            <h3 class="mb-5">{{$thread->title}}</h3>
                            <div style="width: 400px">
                                {!! $thread->body !!}
                            </div>
                        </div>
                        <div class="col-md-3 offset-md-1 thread-show thread-sidebar p-3">
                            <p>Автор: {{$thread->creator->name}}</p>
                            <p>Опубликовано: {{$thread->created_at->diffForHumans()}}</p>
                            @can('delete', $thread)
                                <form action="{{route('thread.delete', $thread->id)}}" method="POST">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button class="btn btn-block btn-danger">Удалить</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <replies :thread-id="{{$thread->id}}"></replies>
                </div>
            </thread>
        </div>
    </div>
@endsection