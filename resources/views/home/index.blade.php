@extends('layouts.app')

@section('content')
    <div class="container">
        @if(auth()->check())
            @foreach($threads as $thread)
                <div class="thread">
                    <div class="thread__header mb-5">
                        <h3>{{$thread->title}}</h3>
                        <p>{{$thread->creator->name}}</p>
                    </div>
                    <div class="thread__body mb-5 text-truncate" style="max-width: 100%;">
                        @if($thread->IsPublished)
                            {!! $thread->body !!}
                        @endif
                    </div>
                    <div class="thread__footer d-flex justify-content-between">
                        <p>{{$thread->created_at->diffForHumans()}}</p>
                        <a href="{{route('thread.show', [$thread->channel, $thread->id])}}"
                           class="btn btn-outline-success">Читать далее</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="vh100">
                <h2 class="home-title text-white text-center">Geadem - темная сторона луны</h2>
            </div>
        @endif
        {{$threads->links()}}
    </div>
@endsection